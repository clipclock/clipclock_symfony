<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 08.11.11
 * Time: 12:13
 * To change this template use File | Settings | File Templates.
 */
 
class daemonModelBase implements daemonInterfaceModel {

	protected $db_driver;

	public function __construct($db_driver)
	{
		$this->db_driver = $db_driver;
	}

	public function execute($sql, $values, $return_array = false)
	{
		return $this->db_driver->execute($sql, $values, $return_array);
	}
}
