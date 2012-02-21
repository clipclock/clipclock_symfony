<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:04
 * To change this template use File | Settings | File Templates.
 */
abstract class daemonWorkerBase implements daemonInterfaceWorker {

	//Amqp only
	protected $amqp_consume_exchange_name;
	protected $amqp_repeat_exchange_name;

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

	/**
	 * @var daemonDriverAmqp
	 */
	protected $amqp_driver;

	protected $amqp_options;
	protected $origin_task;
	protected $origin_queue_name;

	protected $web_dir;

	public function __construct($task, $origin_queue_name)
	{
		$this->task = $task;
		$this->web_dir = __DIR__.'/../../../../web';

		$this->origin_queue_name = $origin_queue_name;

		$this->connectAMQP();

		$this->fromArray($task);
	}

	protected function connectAMQP()
	{
		$this->amqp_driver = new daemonDriverAmqp($this->amqp_options);
	}

	public function disconnectAMQP()
	{
		return $this->amqp_driver->disconnect();
	}

	protected function fromArray($task)
	{
		//Set internal vars
		return false;
	}

	protected function toArray()
	{
		//Fill array from internal vars for save
		return array();
	}

	protected function executeAMQPPublish($message, $options = array())
	{
		if(is_array($message))
		{
			$message = json_encode($message);
		}
		return $this->amqp_driver->execute($message, $options);
	}

	protected function translit($str)
	{
		// Сначала заменяем "односимвольные" фонемы.
		$str = strtr($str, "абвгдеёзийклмнопрстуфхъыэ_", "abvgdeeziyklmnoprstufh'iei");
		$str = strtr($str, "АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_", "ABVGDEEZIYKLMNOPRSTUFH'IEI");

		// Затем - "многосимвольные".
		$str = strtr($str, array(
					  "ж" => "zh", "ц" => "ts", "ч" => "ch", "ш" => "sh",
					  "щ" => "shch", "ь" => "", "ю" => "yu", "я" => "ya",
					  "Ж" => "ZH", "Ц" => "TS", "Ч" => "CH", "Ш" => "SH",
					  "Щ" => "SHCH", "Ь" => "", "Ю" => "YU", "Я" => "YA",
					  "ї" => "i", "Ї" => "Yi", "є" => "ie", "Є" => "Ye"
				 ));

		return $str;
	}
}



function myShutdownHandler()
{
	$error = error_get_last();
	if($error)
	{
		switch ($error['type']) {
			case E_ERROR :
			case E_PARSE :
			case E_CORE_ERROR :
			case E_COMPILE_ERROR :
			case E_USER_ERROR :
			case E_WARNING:
				$error_file = 'critical';
				break;
			case E_NOTICE:
				$error_file = 'notice';
				break;
			default:
				$error_file = 'minor';
				break;
		}

		System_Daemon::warning('['.date("H:i:s m.d.y").'] - ' . $error['type'] . ' - ' .$error['message'] . ' in '. $error['file'] . ' at ' . $error['line']."\n");
	}
}

$old_shutdown_handler = register_shutdown_function("myShutdownHandler");