<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 27.10.11
 * Time: 17:35
 * To change this template use File | Settings | File Templates.
 */

interface daemonInterfaceDriver {

	public function init();
	public function disconnect();
	public function execute($message, $options, $array_return = false);
}
