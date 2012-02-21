<?php
class AMQPQueue
{
	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Create an instance of an AMQPQueue object.
	 * @link http://php.net/manual/en/amqpqueue.construct.php
	 * @param AMQPConnection $amqp_connection [optional] <p> TODO DESCRIPTION </p>
	 * @param string $queue_name [optional] <p> TODO DESCRIPTION </p>
	 * @return  <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * </p>
	 */
	public function __construct($amqp_connection, $queue_name = "") {}

	/**
	 * Acknowledge the receipt of a message
	 * @link http://php.net/manual/en/amqpqueue.ack.php
	 * @param int $delivery_tag [optional] <p> TODO DESCRIPTION </p>
	 * @param int $flags [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function ack($delivery_tag, $flags = NULL) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Bind the given queue to a routing key on an exchange.
	 * @link http://php.net/manual/en/amqpqueue.bind.php
	 * @param string $exchange_name [optional] <p> TODO DESCRIPTION </p>
	 * @param string $routing_key [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function bind($exchange_name, $routing_key) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Cancel a queue binding.
	 * @link http://php.net/manual/en/amqpqueue.cancel.php
	 * @param string $consumer_tag [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function cancel($consumer_tag = "") {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * The consume purpose
	 * @link http://php.net/manual/en/amqpqueue.consume.php
	 * @param array $options [optional] <p> TODO DESCRIPTION </p>
	 * @return array <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * An array containing the messages consumed. The number of returned messages will be at least the number given by <i><tt class="parameter">min</tt></i> in the <i><tt class="parameter">options</tt></i> array. But not more than the number given by <i><tt class="parameter">max</tt></i>.
	 * </p>
	 */
	public function consume($options = array()) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Delete a queue and its contents.
	 * @link http://php.net/manual/en/amqpqueue.delete.php
	 * @param string $queue_name [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function delete($queue_name) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Retrieve the next message from the queue.
	 * @link http://php.net/manual/en/amqpqueue.get.php
	 * @param int $flags [optional] <p> TODO DESCRIPTION </p>
	 * @return array <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns array possibly containing keys <i>routing_key</i>,
	 * <i>exchange</i>, <i>delivery_tag</i>,
	 * <i>Content-type</i>, <i>Content-encoding</i>,
	 * <i>type</i>, <i>timestamp</i>,
	 * <i>priority</i>, <i>expiration</i>,
	 * <i>user_id</i>, <i>app_id</i>,
	 * <i>message_id</i>, <i>Reply-to</i>,
	 * <i>count</i>, <i>msg</i>.
	 * </p>
	 */
	public function get($flags) {}
	
	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Purge the contents of a queue
	 * @link http://php.net/manual/en/amqpqueue.purge.php
	 * @param string $queue_name [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function purge($queue_name) {}
	
	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Unbind the queue from a routing key.
	 * @link http://php.net/manual/en/amqpqueue.unbind.php
	 * @param string $exchange_name [optional] <p> TODO DESCRIPTION </p>
	 * @param string $routing_key [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function unbind($exchange_name, $routing_key) {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Declare a new queue
	 * @link http://php.net/manual/en/amqpqueue.declare.php
	 * @param string $queue_name [optional] <p> TODO DESCRIPTION </p>
	 * @param int $flags [optional] <p> TODO DESCRIPTION </p>
	 * @return int <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns the message count.
	 * </p>
	 */
	//йобанные мудаки блеатьpublic function declare($queue_name = "", $flags) {}
}