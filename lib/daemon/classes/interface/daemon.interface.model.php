<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 18.11.11
 * Time: 11:08
 * To change this template use File | Settings | File Templates.
 */

interface daemonInterfaceModel {

	public function execute($sql, $values, $return_array = false);
}
