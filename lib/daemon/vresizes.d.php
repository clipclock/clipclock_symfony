#!/usr/bin/php -q
<?php
require dirname(__FILE__) . '/classes/daemon.bootstrap.php';
//require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

//$yaml = new sfYaml();

//$configuration = $yaml->load(file_get_contents(sfConfig::get('sf_config_dir', dirname(__FILE__).'/../../config/') . '/amqp.yml'));

//$amqp_options = $configuration['options']['amqp'];
//$amqp_options['consume_exchange_name'] = $configuration['options']['resize']['consume_exchange_name'];
//$amqp_queues_routings = $configuration['options']['resize']['queues'];

$daemon_options = array(
	'appName' => 'vdaemon-resizes',
	'appDir' => dirname(__FILE__).'/daemon',
	'appDescription' => 'Maintains image resizes queues',
	'logVerbosity' => System_Daemon::LOG_INFO,
	'authorName' => 'madesst',
	'authorEmail' => 'madesst@gmail.com',
	'sysMaxExecutionTime' => '0',
	'sysMaxInputTime' => '0',
	'sysMemoryLimit' => '512M',
	'logFilePosition' => 1,
	'logLinePosition' => 1,
	'logTrimAppDir' => 1
);

$queue_max_workers = array(
	'inbox.avatar' => 30,
	'inbox.frame' => 30,
	'outbox.avatar' => 30,
	'outbox.frame' => 30
);

$amqp_options = array(
	'vhost' => '/',
	'port' => '5672',
	'user' => 'videopin',
	'pass' => 'welc0me2IT',

	'consume_exchange_name' => 'resizes.exchanger',
	'repeat_exchange_name' => 'resizes.repeat',

	'amqp_outbox_avatar_queue_name' => 'outbox.avatar'
);

$amqp_queues_routings = array(
	'inbox.avatar',
	'inbox.frame',
	'outbox.avatar',
	'outbox.frame'
);

$daemon = new daemonResizes($daemon_options, $amqp_options, $amqp_queues_routings, $queue_max_workers, $argv);
$daemon->start();