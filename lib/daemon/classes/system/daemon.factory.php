<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 28.10.11
 * Time: 17:43
 * To change this template use File | Settings | File Templates.
 */

class daemonFactory
{
	public static function retrieveWorker($encoded_task, $queue_name, $amqp_options)
	{
		if(!($decoded_task = json_decode($encoded_task, true)))
		{
			throw new daemonExceptionLogic('Unable to json_decode task');
		}

		if(isset($decoded_task['transaction_types_id']) && isset($decoded_task['request_types_id']))
		{
			$worker_type = '';
			$worker_sub_type = '';

			if(!$worker_type || !$worker_sub_type)
			{
				throw new daemonExceptionLogic('Undefined worker for transaction_types_id: '. $decoded_task['transaction_types_id'] .' and request_types_id: '. $decoded_task['request_types_id']);
			}

			$className = 'daemonWorker' . $worker_type . $worker_sub_type;
		}
		else
		{
			throw new daemonExceptionLogic('Unable to json_decode task');
		}

		$obj = new $className($decoded_task, $queue_name, $amqp_options);
		unset($decoded_task);
		unset($queue_name);
		unset($amqp_options);
		unset($className);
		unset($worker_type);
		unset($worker_sub_type);
		return $obj;
	}
}
