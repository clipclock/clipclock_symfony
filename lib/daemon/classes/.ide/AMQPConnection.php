<?php
define('AMQP_DURABLE', 0);
define('AMQP_PASSIVE', 0);
define('AMQP_EXCLUSIVE', 0);
define('AMQP_AUTODELETE', 0);
define('AMQP_INTERNAL', 0);
define('AMQP_NOLOCAL', 0);
define('AMQP_NOACK', 0);
define('AMQP_IFEMPTY', 0);
define('AMQP_IFUNUSED', 0);
define('AMQP_MANDATORY', 0);
define('AMQP_IMMEDIATE', 0);
define('AMQP_MULTIPLE', 0);
define('AMQP_EX_TYPE_DIRECT', 0);
define('AMQP_EX_TYPE_FANOUT', 0);
define('AMQP_EX_TYPE_TOPIC', 0);
define('AMQP_EX_TYPE_HEADER', 0);

class AMQPConnection
{
	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Create an instance of AMQPConnection
	 * @link http://php.net/manual/en/amqpconnection.construct.php
	 * @param array $credentials [optional] <p> TODO DESCRIPTION </p>
	 * @return  <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * An AMQPConnection object.
	 * </p>
	 */
	function __construct($credentials = array()) {}

	/**
	 * Establish a connection with the AMQP broker.
	 * @link http://php.net/manual/en/amqpconnection.connect.php
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function connect() {}

	/**
	 * Closes the connection with the AMQP broker.
	 * @link http://php.net/manual/en/amqpconnection.disconnect.php
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns true if connection was successfully closed, false otherwise.
	 * </p>
	 */
	public function disconnect() {}

	/**
	 * (PECL amqp >= Unknown)<br/>
	 * Determine if the AMQPConnection object is connected to the broker.
	 * @link http://php.net/manual/en/amqpconnection.isconnected.php
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <span class="type">true</span> if connected, <span class="type">false</span> otherwise
	 * </p>
	 */
	public function isConnected() {}

	/**
	 * Closes any open connection and creates a new connection with the AMQP broker.
	 * @link http://php.net/manual/en/amqpconnection.reconnect.php
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function reconnect() {}

	/**
	 * Set the amqp host.
	 * @link http://php.net/manual/en/amqpconnection.sethost.php
	 * @param string $host [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function setHost($host) {}

	/**
	 * Set the login.
	 * @link http://php.net/manual/en/amqpconnection.setlogin.php
	 * @param string $login [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function setLogin($login) {}

	/**
	 * Set the password.
	 * @link http://php.net/manual/en/amqpconnection.setpassword.php
	 * @param string $password [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function setPassword($password) {}

	/**
	 * Set the port.
	 * @link http://php.net/manual/en/amqpconnection.setport.php
	 * @param int $port [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function setPort($port) {}

	/**
	 * Set the amqp virtual host
	 * @link http://php.net/manual/en/amqpconnection.setvhost.php
	 * @param string $vhost [optional] <p> TODO DESCRIPTION </p>
	 * @return bool <h1 class="title">Return Values</h1>
	 * <p class="para">
	 * Returns <b><tt>TRUE</tt></b> on success or <b><tt>FALSE</tt></b> on failure.
	 * </p>
	 */
	public function setVhost($vhost) {}
}
?>