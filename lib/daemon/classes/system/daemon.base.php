<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 16.11.11
 * Time: 9:52
 * To change this template use File | Settings | File Templates.
 */
 
abstract class daemonBase implements daemonInterfaceDaemon {

	protected $gid = 0;
	protected $uid = 0;

	protected $run = true;
	protected $shutdown = false;
	protected $pids = array();

	protected $running_okay = true;
	protected $error_count = 0;

	protected $daemon_pid;

	protected $demon_interval = 0.1;
	protected $daemon_max_workers = 60;

	protected $run_mode = array(
		'help' => false,
		'write-initd' => false,
	);

	protected $amqp_options = array();

	protected $amqp_user;
	protected $amqp_port;
	protected $amqp_vhost;
	protected $amqp_pass;
	protected $amqp_consume_exchange_name;

	protected $daemon_max_workers_per_queue = array();

	public function __construct(array $daemon_options, array $amqp_options)
	{
		$this->amqp_options = $amqp_options;

		$this->amqp_vhost = $amqp_options['vhost'];
		$this->amqp_port = $amqp_options['port'];
		$this->amqp_user = $amqp_options['user'];
		$this->amqp_pass = $amqp_options['pass'];
		$this->amqp_consume_exchange_name = $amqp_options['consume_exchange_name'];

		if($this->run_mode['write-initd'])
		{
			$this->gid = 0;
			$this->uid = 0;
		}

		$daemon_options['appRunAsGID'] = $this->gid;
		$daemon_options['appRunAsUID'] = $this->uid;

		// Help mode. Shows allowed argumentents and quit directly
		if($this->run_mode['help'] == true)
		{
			echo 'Usage: /path/to/script [runmode]' . "\n";
			echo 'Available runmodes:' . "\n";
			foreach($this->run_mode as $run_mod => $val)
			{
				echo ' --' . $run_mod . "\n";
			}
			die();
		}
		System_Daemon::setOptions($daemon_options);
		unset($daemon_options);
		unset($amqp_options);
		unset($amqp_options);
		System_Daemon::setSigHandler(SIGTERM, array(&$this, 'signalHandler'));
		System_Daemon::setSigHandler('SIGCHLD', array(&$this, 'signalChildHandler'));
	}

	public function start()
	{
		System_Daemon::start();

		if($this->run_mode['write-initd'])
		{
			if(($initd_location = System_Daemon::writeAutoRun()) === false)
			{
				System_Daemon::notice('unable to write init.d script');
			}
			else
			{
				System_Daemon::info(
					'sucessfully written startup script: %s',
					$initd_location
				);
			}
		}

		$this->daemon_pid = posix_getpid();

		while(!System_Daemon::isDying() && $this->run && !$this->run_mode['write-initd'])
		{

			if(!$this->running_okay)
			{
				$this->error_count++;

				System_Daemon::err('{appName} produced an error (%s in row)', $this->error_count);
				if($this->error_count >= 3)
				{
					$this->run = false;
				}
			}
			else
			{
				$this->error_count = 0;
			}

			$result = null;

			if($this->daemon_pid == posix_getpid())
			{
				$this->executeDaemon();
			}

			System_Daemon::iterate($this->demon_interval);
		}

		System_Daemon::stop();
	}

	public function signalChildHandler($signo, $pid = null, $status = null)
	{
		if(!$pid)
		{
			$pid = pcntl_waitpid(-1, $status, WNOHANG);
		}

		while ($pid > 0)
		{
			foreach($this->pids as $queue => &$pids)
			{
				if($pid && isset($pids[$pid]))
				{
					unset($pids[$pid]);
				}

			}
			$pid = pcntl_waitpid(-1, $status, WNOHANG);
		}
		//System_Daemon::err(var_export(count($this->pids), true));
		unset($pid);
		unset($status);
	}

	public function signalHandler()
	{
		$waited_pids = array();
		$closed_pids = array();

		$this->shutdown = true;
		System_Daemon::info(
			'Shutdown signal!'
		);

		do
		{
			$need_wait = 0;

			//Sometimes pids update assync, we look for new pids in each cycle
			foreach($this->pids as $pids)
			{
				foreach($pids as $pid => $var)
				{
					System_Daemon::info(
						'wait for: ' . $pid
					);
					//But $pids stores only children that we created at any time, it's not actual about died or not
					if(!isset($waited_pids[$pid]) && !isset($closed_pids[$pid]))
					{
						$waited_pids[$pid] = 1;
					}
				}
			}

			//Look for new died children
			$closing_pid = pcntl_waitpid(-1, $status, WNOHANG);
			if($closing_pid > 0)
			{
				if(isset($waited_pids[$closing_pid]))
				{
					$closed_pids[$closing_pid] = 1;
					unset($waited_pids[$closing_pid]);
				}
			}
			else
			{
				//Maybe all children already died?
				foreach($waited_pids as $waited_pid => $time)
				{
					if(pcntl_waitpid($waited_pid, $status) != -1)
					{
						$need_wait = 1;
					}
				}

				//All pids are not founded in system, all children are died or gone away
				if(!$need_wait)
				{
					$waited_pids = array();
				}
			}
		}
		while(count($waited_pids));
		$this->run = false;
	}

	public function setDemonInterval($demon_interval)
	{
		$this->demon_interval = $demon_interval;
	}

	public function getDemonInterval()
	{
		return $this->demon_interval;
	}

	public function setDaemonMaxWorkers($daemon_max_workers)
	{
		$this->daemon_max_workers = $daemon_max_workers;
	}

	public function getDaemonMaxWorkers()
	{
		return $this->daemon_max_workers;
	}

}
