<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 */

class daemonWorkerOutboxResize extends daemonWorkerBase {

	//Internal vars
	protected 	$task_type,
				$original_path,
				$save_path,
				$sizes,
				$delete;

	public function __construct($task, $queueName, $amqp_options)
	{
		$this->amqp_options = $amqp_options;

		$this->amqp_consume_exchange_name = $amqp_options['amqp_consume_exchange_name'];
		$this->amqp_repeat_exchange_name = $amqp_options['amqp_repeat_exchange_name'];

		parent::__construct($task, $queueName);
	}

	public function executeTask()
	{
		if(!file_exists($this->original_path))
		{
			var_dump('no original file!');
			return false;
		}
		$im = imagecreatefromjpeg($this->original_path);

		if($this->sizes['width'] != imagesx($im) || $this->sizes['height'] / imagesy($im))
		{
			$k1 = $this->sizes['width'] / imagesx($im);
			$k2 = $this->sizes['height'] / imagesy($im);
			$k = $k1 > $k2 ? $k2 : $k1;

			$w = intval(imagesx($im) * $k);
			$h = intval(imagesy($im) * $k);

			$im1 = imagecreatetruecolor($w, $h);
			imagecopyresampled($im1, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));

			imagejpeg($im1, $this->save_path, 100);
			imagedestroy($im1);
		}
		imagedestroy($im);

		$this->checkForDelete();
	}

	public function checkForDelete()
	{
		$check_array = $this->delete['check'];
		foreach($this->delete['check'] as $key => $check_path)
		{
			if(file_exists($check_path))
			{
				unset($check_array[$key]);
			}
		}

		if(!count($check_array))
		{
			foreach($this->delete['path'] as $path)
			{
				unlink($path);
			}
		}
	}

	protected function connectAMQP()
	{

	}

	protected function fromArray($task)
	{
		$this->task_type = $task['task_type'];
		$this->original_path = $task['original_path'];
		$this->sizes = $task['resize'];
		$this->save_path = $task['save_path'];
		$this->delete = $task['delete'];
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