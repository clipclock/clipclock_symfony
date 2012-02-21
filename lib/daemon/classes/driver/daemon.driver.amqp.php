<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 27.10.11
 * Time: 17:27
 * To change this template use File | Settings | File Templates.
 */
 
class daemonDriverAmqp implements daemonInterfaceDriver {

	protected $amqp_user;
	protected $amqp_pass;
	protected $amqp_port;
	protected $amqp_vhost;
	protected $amqp_exchange_name;
	protected $amqp_routing_name;
	protected $amqp_queue_name;
	protected $amqp_consume_exchange_name;

	protected $amqp_queue_length;

	/**
	 * @var AMQPConnection
	 */
	protected $amqp_connection;

	/**
	 * @var AMQPExchange
	 */
	protected $amqp_exchange;

	/**
	 * @var AMQPQueue
	 */
	protected $amqp_queue;

	public function __construct($amqp_options)
	{
		$this->amqp_vhost = $amqp_options['vhost'];
		$this->amqp_port = $amqp_options['port'];
		$this->amqp_user = $amqp_options['user'];
		$this->amqp_pass = $amqp_options['pass'];
		$this->amqp_consume_exchange_name = $amqp_options['amqp_consume_exchange_name'];
		unset($amqp_options);
	}

	public function init($amqp_queue_name = null, $amqp_exchange_name = null)
	{
		if(!$amqp_queue_name)
		{
			$amqp_queue_name = $this->amqp_queue_name;
		}

		$amqp_routing_name = $amqp_queue_name;
		$amqp_exchange_name = $amqp_exchange_name ? $amqp_exchange_name : $this->amqp_consume_exchange_name.'.'.$amqp_queue_name;

		try
		{
			$this->amqp_connection = new AMQPConnection(array('port' => $this->amqp_port, 'login' => $this->amqp_user, 'password' => $this->amqp_pass, 'vhost' => $this->amqp_vhost));
			$this->amqp_connection->connect();

			$this->amqp_queue = new AMQPQueue($this->amqp_connection);
			$this->amqp_queue_length = $this->amqp_queue->declare($amqp_queue_name, AMQP_DURABLE);

			$this->amqp_exchange = new AMQPExchange($this->amqp_connection);
			$this->amqp_exchange->declare($amqp_exchange_name, AMQP_EX_TYPE_FANOUT);

			//$this->amqp_exchange->bind($amqp_queue_name, $amqp_routing_name);
			$this->amqp_queue->bind($amqp_exchange_name, $amqp_routing_name);

			$this->amqp_exchange_name = $amqp_exchange_name;
			$this->amqp_queue_name = $amqp_queue_name;
			$this->amqp_routing_name = $amqp_routing_name;
		}
		catch(AMQPException $e)
		{
			$this->init($amqp_queue_name, $amqp_exchange_name);
		}

		return $this->amqp_connection;
	}

	public function execute($message, $options = array(), $array_return = false)
	{
		if(!$this->amqp_connection)
		{
			$this->init();
		}

		return $this->amqp_exchange->publish($message, $this->amqp_queue_name, null, $options ? $options : array());
	}

	public function disconnect()
	{
		if($this->amqp_connection)
		{
			if($this->amqp_connection->disconnect())
			{
				$this->amqp_connection = null;
				return true;
			}
		}

		return false;
	}

	public function deleteExchange($amqp_exchange_name = null)
	{
		if($this->amqp_connection)
		{
			$amqp_exchange = new AMQPExchange($this->amqp_connection);
			$amqp_exchange->delete($amqp_exchange_name ? $amqp_exchange_name : $this->getAmqpExchangeName());
		}
	}

	public function __destruct()
	{
		$this->disconnect();
	}

	public function getAmqpExchangeName()
	{
		return $this->amqp_exchange_name;
	}
}
