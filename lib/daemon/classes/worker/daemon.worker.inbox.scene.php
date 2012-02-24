<?php
require_once(__DIR__.'/../../../utils/Image.preview.class.php');
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 */

class daemonWorkerInboxScene extends daemonWorkerBase {

	//Amqp only
	protected $amqp_inbox_avatar_queue_name;

	protected $helper;

	//Internal vars
	protected 	$task_type,
				$url,
				$time,
				$c14n_id;

	protected $original_path = '';
	protected $dir_path;
	protected $c14n_name;

	protected $to_task_values = array();

	public function __construct($task, $queueName, $amqp_options)
	{
		$this->amqp_options = $amqp_options;

		$this->amqp_consume_exchange_name = $amqp_options['amqp_consume_exchange_name'];
		$this->amqp_repeat_exchange_name = $amqp_options['amqp_repeat_exchange_name'];
		$this->amqp_inbox_avatar_queue_name = $amqp_options['amqp_inbox_avatar_queue_name'];

		$this->helper = new daemonHelperSceneExtract();

		parent::__construct($task, $queueName);
	}

	public function executeTask()
	{
		$this->helper->retrieveFrame($this->url, $this->time);
		$temp_frame_path = $this->helper->temp_frame_path;
		$temp_dir_path = $this->helper->temp_dir_path;
		if(file_exists($temp_frame_path))
		{
			$this->saveOriginalImage($temp_frame_path, ImagePreview::c14n($this->c14n_id, 'original_scene', 'scene'));
			rmdir($temp_dir_path);
		}

		$to_task_values = array();
		$to_task_values['task_type'] = 1;
		$to_task_values['path'] = $this->original_path;
		$to_task_values['sizes'] = array(
			'scenes' => array(
				'big',
				'medium',
			)
		);
		$to_task_values['c14n_id'] = $this->c14n_id;
		$this->executeAMQPPublish($to_task_values);
	}

	protected function saveOriginalImage($temp_path, $path)
	{
		$this->preparePath($path);
		$this->original_path = $this->web_dir.$this->dir_path . DIRECTORY_SEPARATOR . $this->c14n_name;

		if(!file_exists($this->original_path))
		{
			rename($temp_path, $this->original_path);
		}
		else
		{
			unlink($temp_path);
		}
	}

	protected function preparePath($path)
	{
		$path_parts = explode(DIRECTORY_SEPARATOR, $path);
		$dir_path = '';
		foreach($path_parts as $path_part)
		{
			if($path_part && !strpos($path_part, '.'))
			{
				$dir_path = $dir_path . DIRECTORY_SEPARATOR . $path_part;
			}
			else
			{
				$this->c14n_name = $path_part;
			}
		}
		@mkdir($this->web_dir.$dir_path, 0777, true);
		$this->dir_path = $dir_path;
	}

	protected function connectAMQP()
	{
		$this->amqp_driver = new daemonDriverAmqp($this->amqp_options);
		$this->amqp_driver->init($this->amqp_inbox_avatar_queue_name);
	}

	protected function fromArray($task)
	{
		$this->task_type = $task['task_type'];
		$this->url = $task['url'];
		$this->c14n_id = $task['c14n_id'];
		$this->time = $task['time'];
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