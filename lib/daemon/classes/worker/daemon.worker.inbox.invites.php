<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 */

class daemonWorkerInboxInvites extends daemonWorkerBase {

	/**
	 * @var daemonDriverDb
	 */
	protected $db_driver;

	//Amqp only
	protected $amqp_inbox_avatar_queue_name;

	protected $helper;

	//Internal vars
	protected 	$task_type,
				$author_id,
				$invited_ids,
				$timestamp;

	protected $to_task_values = array();

	public function __construct($task, $queueName, $amqp_options)
	{
		$this->amqp_options = $amqp_options;

		$this->amqp_consume_exchange_name = $amqp_options['amqp_consume_exchange_name'];
		$this->amqp_repeat_exchange_name = $amqp_options['amqp_repeat_exchange_name'];

		parent::__construct($task, $queueName);

		$this->connectDB();
		$this->db_model = new daemonModelInvites($this->db_driver);
	}

	protected function connectDB()
	{
		$this->db_driver = new daemonDriverDb();
	}

	public function executeTask()
	{
		try
		{
			$this->db_model->addAllUserIds($this->invited_ids, $this->author_id, $this->timestamp);
		}
		catch(daemonExceptionLogic $e)
		{
			foreach($this->invited_ids as $invited_id)
			{
				$this->db_model->addOneUserId($invited_id, $this->author_id, $this->timestamp);
			}
		}

	}

	protected function connectAMQP()
	{
		/*$this->amqp_driver = new daemonDriverAmqp($this->amqp_options);
		$this->amqp_driver->init($this->amqp_inbox_avatar_queue_name);*/
	}

	protected function fromArray($task)
	{
		$this->task_type = $task['task_type'];
		$this->author_id = $task['author_id'];
		$this->timestamp = $task['timestamp'];
		$this->invited_ids = $task['invited_ids'];
	}

	protected function toArray()
	{
		$array = parent::toArray();

		return $array;
	}

	public function handleFatalException(daemonExceptionFatalBase $e)
	{
		return false;
	}

	public function handleUnrepeatableException(daemonExceptionUnrepeatableBase $e)
	{
		return false;
	}

	public function handleException(Exception $e)
	{
		return false;
	}

	public function handleRepeatableException(daemonExceptionRepeatableBase $e)
	{
		$amqp_finished = new daemonDriverAmqp($this->amqp_options);
		$time = microtime(true);
		$amqp_finished->init($this->origin_queue_name, $this->amqp_repeat_exchange_name.$time);

		$task = $this->task;
		$task['attemp'] = ++$this->attemp;
		$amqp_finished->execute(json_encode($task), array('timestamp' => time() + $this->attemp_intervals[$this->attemp-1]));
		$amqp_finished->deleteExchange($this->amqp_repeat_exchange_name.$time);
	}
}