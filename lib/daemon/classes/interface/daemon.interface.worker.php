<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.10.11
 * Time: 14:03
 * To change this template use File | Settings | File Templates.
 */

interface daemonInterfaceWorker {

	public function disconnectAMQP();

	public function executeTask();

	public function handleFatalException(daemonExceptionFatalBase $e);
	public function handleRepeatableException(daemonExceptionRepeatableBase $e);
	public function handleUnrepeatableException(daemonExceptionUnrepeatableBase $e);
	public function handleException(Exception $e);
}
