<?php
require_once(__DIR__.'/../../../utils/Image.preview.class.php');
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 */

class daemonWorkerInboxResize extends daemonWorkerBase {

	//Amqp only
	protected $amqp_outbox_avatar_queue_name;

	protected $helper;

	//Internal vars
	protected 	$task_type,
				$url,
				$path,
				$sizes,
				$c14n_id,
				$force;
	protected $original_paths = array();
	protected $save_paths = array();
	protected $dir_path;
	protected $c14n_name;

	protected $to_task_values = array();

	public function __construct($task, $queueName, $amqp_options)
	{
		$this->amqp_options = $amqp_options;

		$this->amqp_consume_exchange_name = $amqp_options['amqp_consume_exchange_name'];
		$this->amqp_repeat_exchange_name = $amqp_options['amqp_repeat_exchange_name'];
		$this->amqp_outbox_avatar_queue_name = $amqp_options['amqp_outbox_avatar_queue_name'];

		$this->helper = new daemonHelperBaseSend();

		parent::__construct($task, $queueName);
	}

	public function executeTask()
	{
		$check_paths = array();
		$delete_paths = array();
		foreach($this->sizes as $url_key => $sizes)
		{
			if(!$this->path)
			{
				$this->saveOriginalImage($this->url[$url_key], ImagePreview::c14n($this->c14n_id, 'original_'.$url_key, 'avatar'), $url_key);
				$type = 'avatar';
			}
			else
			{
				$this->original_paths[$url_key] = $this->path;
				$type = 'scene';
			}

			$delete_paths[] = $this->original_paths[$url_key];
			foreach($sizes as $size)
			{
				$this->save_paths[$url_key][$size] = ImagePreview::c14n($this->c14n_id, $size, $type);
				$check_paths[] = $this->web_dir.$this->save_paths[$url_key][$size];
				$this->preparePath($this->save_paths[$url_key][$size]);
			}
		}

		foreach($this->sizes as $url_key => $sizes)
		{
			foreach($sizes as $size)
			{
				$real_size = ImagePreview::getRealSize($size, $type);
				$to_task_values = array();
				$to_task_values['delete']['path'] = $delete_paths;
				$to_task_values['delete']['check'] = $check_paths;
				$to_task_values['resize']['width'] = substr($real_size, 0, strpos($real_size, 'x'));
				$to_task_values['resize']['height'] = substr($real_size, strpos($real_size, 'x')+1, strlen($real_size)-strpos($real_size, 'x'));
				$to_task_values['original_path'] = $this->original_paths[$url_key];
				$to_task_values['save_path'] = $this->web_dir.$this->save_paths[$url_key][$size];
				$this->to_task_values[] = $to_task_values;
			}
		}

		foreach($this->to_task_values as $to_task)
		{
			$to_task['task_type'] = 2;
			$this->executeAMQPPublish($to_task);
		}
	}

	protected function saveOriginalImage($url, $path, $url_key)
	{
		$this->preparePath($path);
		$this->original_paths[$url_key] = $this->web_dir.$this->dir_path . DIRECTORY_SEPARATOR . $this->c14n_name;

		if($this->force || !file_exists($this->original_paths[$url_key]))
		{
			$image = $this->helper->getImage($url);
			imagejpeg($image, $this->original_paths[$url_key], 100);
			unset($image);
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
		$this->amqp_driver->init($this->amqp_outbox_avatar_queue_name);
	}

	protected function fromArray($task)
	{
		$this->task_type = $task['task_type'];
		$this->url = $task['url'];
		$this->path = $task['path'];
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