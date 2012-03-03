<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 16.11.11
 * Time: 9:53
 * To change this template use File | Settings | File Templates.
 */
 
class daemonConsume extends daemonBase {

	protected $amqp_queues_routings = array();
	protected $amqp_connection;
	protected $amqp_channel;
	protected $amqp_queues;

	protected $i=0;
	
	public function __construct(array $daemon_options, array $amqp_options, array $amqp_queues_routings, array $queue_max_workers, array $run_mode)
	{
		$this->amqp_queues_routings = $amqp_queues_routings;

        foreach($this->amqp_queues_routings as $routing)
        {
            $this->pids[$routing] = (empty($this->pids[$routing])) ? array() : $this->pids[$routing];
        }

		// Scan command line attributes for allowed arguments
		foreach($run_mode as $arg)
		{
			if(substr($arg, 0, 2) == '--' && isset($this->run_mode[substr($arg, 2)]))
			{
				$this->run_mode[substr($arg, 2)] = true;
			}
		}
		unset($run_mode);
		unset($arg);

		parent::__construct($daemon_options, $amqp_options);

		foreach($this->amqp_queues_routings as $queue)
		{
			if(isset($queue_max_workers[$queue]) && $queue_max_workers[$queue] > 0)
			{
				$this->daemon_max_workers_per_queue[$queue] = $queue_max_workers[$queue];
			}
			else
			{
				$this->daemon_max_workers_per_queue[$queue] = $this->daemon_max_workers;
			}
		}
	}

	public function executeDaemon()
	{
		/*if(count($this->pids) >= $this->daemon_max_workers)
		{
			System_Daemon::err(
				'REACHED MAX PID COUNT: '.count($this->pids)
			);
			while(!$this->shutdown && (count($this->pids) > $this->daemon_max_workers - ceil($this->daemon_max_workers / 2)))
			{
				usleep(100);
			}
			System_Daemon::err(
				'REACHED NORMAL PID COUNT: '.count($this->pids)
			);
		}*/

		$this->reconnect();
		do
		{
			foreach($this->amqp_queues_routings as $queue)
			{
				if(count($this->pids[$queue]) < $this->daemon_max_workers_per_queue[$queue])
				{
					$this->consumeAndExecute($queue);
				}
			}
		}
		while(!$this->shutdown && $this->countPids() > 0);

		unset($queue);
	}

	protected function countPids()
	{
		$count = 0;
		foreach($this->pids as $queue => $pids)
		{
			$count = $count + count($pids);
		}
		unset($pids);
		unset($queue);

		return $count;
	}

	protected function reconnect()
	{
		try
		{
			if(!$this->amqp_connection)
			{
				$this->amqp_connection = new AMQPConnection(array(
					'port' => $this->amqp_port,
					'login' => $this->amqp_user,
					'password' => $this->amqp_pass,
					'vhost' => $this->amqp_vhost));
				$this->amqp_connection->connect();
				$this->refillAmqpQueues();
			}
			elseif(!$this->amqp_connection->isConnected())
			{
				$this->amqp_connection->reconnect();
				$this->refillAmqpQueues();
			}
		}
		catch(Exception $e)
		{
			if(!$this->shutdown)
			{
				$this->reconnect();
			}
		}
	}

	protected function refillAmqpQueues()
	{
		foreach($this->amqp_queues_routings as $queue)
		{
			$amqp_queue= new AMQPQueue($this->amqp_connection, $queue);
			//$amqp_queue->declare($queue, AMQP_DURABLE);

			$this->amqp_queues[$queue] = $amqp_queue;
			unset($amqp_queue);
		}
		unset($queue);
	}

	protected function consumeAndExecute($queueName)
	{
		$this->reconnect();
		$amqp_queue = $this->amqp_queues[$queueName];
		$raw_tasks = array();

		$raw_task = $amqp_queue->get();

		if($raw_task['count'] >= 0)
		{

			$raw_tasks[] = $raw_task;
			for($i = 1; $i < 5; $i++)
			{
				$raw_task = $amqp_queue->get();
				if($raw_task['count'] == -1)
				{
					break;
				}

				$raw_tasks[] = $raw_task;
			}
		}

		unset($amqp_queue);

		if(count($raw_tasks))
		{
			$tasks = $this->executeConsumeCallback($queueName, $raw_tasks);
			if(count($tasks))
			{
				$this->amqp_connection->disconnect();
				$pid = pcntl_fork();
				if($pid == -1)
				{
					System_Daemon::err(
						'could not fork'
					);

					$this->running_okay = false;
				}
				elseif($pid)
				{
					$this->pids[$queueName][$pid] = 1;
					System_Daemon::info(
						'finded ' . count($tasks) . ' task; from queue: ' . $queueName . '; started worker: ' . $pid
					);

					unset($pid);
					unset($raw_task);
					unset($queueName);
					unset($tasks);
					unset($raw_tasks);
				}
				else
				{
					fclose(STDIN);
					fclose(STDOUT);
					fclose(STDERR);

					foreach($tasks as $task)
					{
						$this->executeTask($task, $queueName);
					}

					unset($tasks);
					unset($pid);
					unset($raw_task);
					unset($raw_tasks);
					unset($task);
					unset($queueName);
					unset($this->amqp_connection);
					unset($this->amqp_queues);
					unset($this->amqp_queues_routings);
					unset($this->pids);
					unset($this->amqp_options);
					unset($this);
					exit;
				}
			}
		}
		else
		{
			usleep(1000);
		}
	}

	protected function executeConsumeCallback($queueName, $raw_tasks)
	{
		$check_tasks = $raw_tasks;
		foreach($check_tasks as $key => $raw_task)
		{
			if(!isset($raw_task['timestamp']))
			{
				continue;
			}
			else
			{
				if($raw_task['timestamp'] > time())
				{
					$exchange = new AMQPExchange($this->amqp_connection);
					$exchange->declare($this->amqp_consume_exchange_name.'_republish_exchange', AMQP_EX_TYPE_FANOUT);
					$exchange->bind($queueName, $this->amqp_consume_exchange_name.'_republish_route');
					$exchange->publish($raw_task['msg'], $this->amqp_consume_exchange_name.'_republish_route', null, array('timestamp' => $raw_task['timestamp']));
					unset($raw_tasks[$key]);

					//republish in queue
					//unset from raw_tasks
				}
			}
		}

		unset($key);
		unset($raw_task);
		unset($check_tasks);
		unset($exchange);
		return $raw_tasks;
		/*
		foreach($raw_tasks as $raw_task)
		{
			$queue->ack($raw_task['delivery_tag']);
		}*/
	}

	protected function executeTask($task, $queueName)
	{
		try
		{
			$worker = $this->retrieveWorker($task, $queueName);
			unset($task);
			unset($queueName);
		}
		catch(Exception $e)
		{
			unset($worker);
			System_Daemon::warning(
				var_export($e, true)
			);
			unset($e);
			return false;
		}
		if($worker)
		{
			try
			{
				$worker->executeTask();
			}
			catch(daemonExceptionFatalBase $e)
			{
				$worker->handleFatalException($e);
				return false;
			}
			catch(Exception $e)
			{
				//Pre hook for all non-fatal errors
				$worker->handleException($e);

				$class = new ReflectionClass(get_class($e));
				switch($class->getParentClass()->getName())
				{
					default:
					case 'daemonExceptionUnrepeatableBase':
					var_dump($e);
						$worker->handleUnrepeatableException($e);
						break;
					case 'daemonExceptionRepeatableBase':
						$worker->handleRepeatableException($e);
						break;
				}

				unset($worker);
				unset($class);
				unset($e);
				return;
			}
			unset($worker);
			return true;
		}
		return;
	}
}
