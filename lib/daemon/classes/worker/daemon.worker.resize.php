<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 */

class daemonWorkerResize extends daemonWorkerBase {

	protected $attemp = 1;

	protected $attemp_intervals = array(
		10,
		30,
		60,
		90,
		120,
		3600,
		3600,
		3600,
		3600,
		3600,
		3600,
		3600,
		3600,
		3600
	);

	//Amqp only
	protected $amqp_consume_exchange_name;
	protected $amqp_repeat_exchange_name;

	//Internal vars
	protected 	$task_type,
				$url,
				$sizes,
				$c14n_id,
				$force;

	public function __construct($task, $queueName, $amqp_options)
	{
		$this->amqp_options = $amqp_options;

		$this->amqp_consume_exchange_name = $amqp_options['amqp_consume_exchange_name'];
		$this->amqp_repeat_exchange_name = $amqp_options['amqp_repeat_exchange_name'];

		parent::__construct($task, $queueName);
	}

	public function executeTask()
	{
		parent::executeTask();

		System_Daemon::notice($this->task['url']['photo']);
	}

	protected function connectAMQP()
	{
		/*$this->amqp_driver = new daemonDriverAmqp($this->amqp_options);
		$this->amqp_driver->init($this->amqp_outbox_agregators_queue_name);*/
	}

	protected function fromArray($task)
	{
		$this->task_type = $task['task_type'];
		$this->url = $task['url'];
		$this->sizes = $task['sizes'];
		$this->c14n_id = $task['c14n_id'];
		$this->force = $task['force'];
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