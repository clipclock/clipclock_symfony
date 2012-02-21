<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:04
 * To change this template use File | Settings | File Templates.
 */
abstract class daemonWorkerBase implements daemonInterfaceWorker {

	/**
	 * @var daemonDriverAmqp
	 */
	protected $amqp_driver;

	protected $amqp_options;
	protected $origin_task;
	protected $origin_queue_name;

	public function __construct($task, $origin_queue_name)
	{
		$this->task = $task;

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
