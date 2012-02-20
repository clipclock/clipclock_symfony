<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 16.11.11
 * Time: 11:09
 * To change this template use File | Settings | File Templates.
 */
 
class daemonResizes extends daemonConsume {

	public function __construct(array $daemon_options, array $amqp_options, array $amqp_queues_routings, array $queue_max_workers, array $run_mode) //$argv
	{
		parent::__construct($daemon_options, $amqp_options, $amqp_queues_routings, $queue_max_workers, $run_mode);
	}

	protected function retrieveWorker($task, $queueName)
	{
		return new daemonWorkerResize(json_decode($task->getBody(), true), $queueName, $this->amqp_options);
	}
}
