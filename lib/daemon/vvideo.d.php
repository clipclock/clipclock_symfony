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
	'appName' => 'vdaemon-video',
	'appDir' => dirname(__FILE__),
	'appDescription' => 'Maintains frame extraction queues',
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
	'inbox.scene' => 1,
);

$amqp_options = array(
	'vhost' => '/',
	'port' => '5672',
	'user' => 'videopin',
	'pass' => 'welc0me2IT',

	'consume_exchange_name' => 'scenes.exchanger',
	'repeat_exchange_name' => 'scenes.repeat',

	'amqp_inbox_avatar_queue_name' => 'inbox.avatar',
);

$amqp_queues_routings = array(
	'inbox.scene'
);

$daemon = new daemonScenes($daemon_options, $amqp_options, $amqp_queues_routings, $queue_max_workers, $argv);
$daemon->start();