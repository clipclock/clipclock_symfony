<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 20.02.12
 * Time: 19:43
 * To change this template use File | Settings | File Templates.
 */
class daemonForker
{
	static $running_okay = true;
	public static function pleaseFork($tasks)
	{
		if(count($tasks))
		{
			$pid = pcntl_fork();
			if($pid == -1)
			{
				System_Daemon::err(
					'could not fork'
				);

				self::$running_okay = false;
			}
			elseif($pid)
			{
				return $pid;
			}
			else
			{
				fclose(STDIN);
				fclose(STDOUT);
				fclose(STDERR);

				foreach($tasks as $task)
				{
					//$this->executeTask($task, $queueName);
				}

				exit;
			}
		}
		return $pid;
	}
}
