<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 22.02.12
 * Time: 16:26
 * To change this template use File | Settings | File Templates.
 */
class AMQPPublisher
{
	protected $connection;

	protected $amqp_queue_names = array(
		'scene' => 'inbox.scene',
		'avatar' => 'inbox.avatar',
		'invites' => 'inbox.invites'
	);

	public function __construct()
	{
		$this->amqp_vhost = '/';
		$this->amqp_port = '5672';
		$this->amqp_user = 'videopin';
		$this->amqp_pass = 'welc0me2IT';
		$this->amqp_publisher_exchange_name = 'symfony';

		$this->connection = new AMQPConnection(array(
			'host' => '127.0.0.1',
			'port' => $this->amqp_port,
			'login' => $this->amqp_user,
			'password' => $this->amqp_pass,
			'vhost' => $this->amqp_vhost));
		$this->connection->connect();
	}

	public function jobScene($scene_time_id, $video_url, $time)
	{
		return $this->publishJob(array(
			'task_type' => 3,
			'url' => $video_url,
			'time' => $time,
			'c14n_id' => $scene_time_id,
		), $this->amqp_queue_names['scene']);
	}

	public function jobInvites($invited_ids, $author_id, $timestamp)
	{
		return $this->publishJob(array(
			'task_type' => 5,
			'invited_ids' => $invited_ids,
			'author_id' => $author_id,
			'timestamp' => $timestamp,
		), $this->amqp_queue_names['invites']);
	}

	public function jobAvatar($user_id, $photo_url, $avatar_url)
	{
		return $this->publishJob(array(
			'task_type' => 1,
			'url' => array(
				'photo' => $photo_url,
				'avatar' => $avatar_url,
			),
			'sizes' => array(
				'avatar' => array(
					'medium',
					'small',
					'tiny'
				),
				'photo' => array(
					'big'
				)
			),
			'c14n_id' => $user_id,
		), $this->amqp_queue_names['avatar']);
	}

	protected function publishJob($job, $queue_name)
	{
		$ex = $this->generatePublisher($queue_name);
		$this->generateQueue($queue_name, $this->amqp_publisher_exchange_name);

		return $ex->publish(json_encode($job), 'routing.key');
	}

	protected function generatePublisher($queue_name)
	{
		$this->amqp_publisher_exchange_name = $this->amqp_publisher_exchange_name.'.'.$queue_name;
		$ex = new AMQPExchange($this->connection);
		$ex->declare($this->amqp_publisher_exchange_name, AMQP_EX_TYPE_FANOUT);

		return $ex;
	}

	protected function generateQueue($queue_name, $exchange_name)
	{
		$q = new AMQPQueue($this->connection);
		$q->declare($queue_name, AMQP_DURABLE);
		$q->bind($exchange_name, 'routing.key');

		return $q;
	}
}