<?php

// Create a connection
$cnn = new AMQPConnection(array(
	'host' => '127.0.0.1',
	'port' => '5672',
	'login' => 'videopin',
	'password' => 'welc0me2IT',
	'vhost' => '/'));
$cnn->connect();

// Declare a new exchange
$ex = new AMQPExchange($cnn);
$ex->declare('exchange1', AMQP_EX_TYPE_FANOUT);

// Create a new queue
$q = new AMQPQueue($cnn);
$q->declare('inbox.avatar', AMQP_DURABLE);

// Bind it on the exchange to routing.key
//$ex->bind('inbox.avatar', 'routing.key');
$q->bind('exchange1', 'routing.key');

for($i = 0; $i < 1; $i++)
{
	// Publish a message to the exchange with a routing key
	$ex->publish(json_encode(array(
		'task_type' => 1,
		'url' => array(
			'photo' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash2/274126_1464279882_4809198_n.jpg',
			'avatar' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash2/274126_1464279882_4809198_q.jpg',
		),
		'sizes' => array(
			'avatar' => array(
				'medium',
				'small',
				'tiny'
			),
			'photo' => array(
				'big'
			)
		),
		'c14n_id' => 58,
	)), 'routing.key');

}