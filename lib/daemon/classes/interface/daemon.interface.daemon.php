<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 16.11.11
 * Time: 11:34
 * To change this template use File | Settings | File Templates.
 */
 
interface daemonInterfaceDaemon {

	public function start();
	public function signalHandler();
	public function executeDaemon();

	public function setDemonInterval($demon_interval);
	public function setDaemonMaxWorkers($daemon_max_workers);
}
