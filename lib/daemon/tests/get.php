<?php

/* Create a connection using all default credentials: */

do{

	$connection = new AMQPConnection(array(
		'host' => '127.0.0.1',
		'port' => '5672',
		'login' => 'videopin',
		'password' => 'welc0me2IT',
		'vhost' => '/'));
	$connection->connect();

	$channel = new AMQPChannel($connection);

	/* create a queue object */
	$queue = new AMQPQueue($channel);
	$queue->setName('inbox.avatar');
	$queue->setFlags(AMQP_DURABLE);
	//declare the queue
	$queue->declare();

//get the messages
$messages = $queue->get(AMQP_AUTOACK);
	if($messages)
	{
//		print_r($messages);
	}
}
while($messages);

?>