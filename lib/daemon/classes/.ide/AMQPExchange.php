<?php
class AMQPExchange
{
	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Create an instance of AMQPExchange
	 * @link http://php.net/manual/en/amqpexchange.construct.php
	 * @param AMQPConnection $connection [optional] <p> TODO DESCRIPTION </p>
	 * @param string $exchange_name [optional] <p> TODO DESCRIPTION </p>
	 * @return  <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * An <span class="classname">AMQPExchange</span> object.
	 * </p>
	 */
	public function __construct($connection, $exchange_name = "") {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * The bind purpose
	 * @link http://php.net/manual/en/amqpexchange.bind.php
	 * @param string $queue_name [optional] <p> TODO DESCRIPTION </p>
	 * @param string $routing_key [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function bind($queue_name, $routing_key) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Delete the exchange from the broker.
	 * @link http://php.net/manual/en/amqpexchange.delete.php
	 * @param string $exchange_name [optional] <p> TODO DESCRIPTION </p>
	 * @param int $params [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function delete($exchange_name = NULL, $params) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Publish a message to an exchange.
	 * @link http://php.net/manual/en/amqpexchange.publish.php
	 * @param string $message [optional] <p> TODO DESCRIPTION </p>
	 * @param string $routing_key [optional] <p> TODO DESCRIPTION </p>
	 * @param int $params [optional] <p> TODO DESCRIPTION </p>
	 * @param array $attributes [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function publish($message, $routing_key, $params, $attributes) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Declare a new exchange on the broker.
	 * @link http://php.net/manual/en/amqpexchange.declare.php
	 * @param string $exchange_name [optional] <p> TODO DESCRIPTION </p>
	 * @param string $exchange_type [optional] <p> TODO DESCRIPTION </p>
	 * @param int $flags [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	//public function declare($exchange_name = "", $exchange_type, $flags) {}
}
?>