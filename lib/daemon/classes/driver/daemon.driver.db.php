<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 27.10.11
 * Time: 17:26
 * To change this template use File | Settings | File Templates.
 */
 
class daemonDriverDb implements daemonInterfaceDriver {

	protected $db_connection;

	protected $db_host = 'localhost';
	protected $db_port = '5432';
	protected $db_name = 'viddii';
	protected $db_user = 'viddii';
	protected $db_pass = '123';

	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		$db_connection = pg_connect('host=' . $this->db_host . ' port=' . $this->db_port . ' dbname=' . $this->db_name . ' user=' . $this->db_user . ' password=' . $this->db_pass);
		if(!$db_connection)
		{
			throw new daemonExceptionDbConnection('Couldnt connect to DB');
		}

		$this->db_connection = $db_connection;

		return $this->db_connection;
	}

	public function execute($sql, $values, $return_array = false)
	{
		if(!$this->db_connection)
		{
			$this->init();
		}

		try
		{
			$result = pg_query_params($this->db_connection, $sql, $values);
		}
		catch(Exception $e)
		{
			throw new daemonExceptionLogic('Error query binding' . pg_last_error());
		}

		if(!$result)
		{
			throw new daemonExceptionLogic('Error query binding' . pg_last_error());
		}

		if(($error = pg_result_error($result)))
		{
			throw new daemonExceptionLogic('Error query' . $error);
		}

		$rows = pg_fetch_all($result);

		if(pg_num_rows($result) == 1)
		{
			return $rows[0];
		}

		return $rows;
	}

	public function disconnect()
	{
		if($this->db_connection)
		{
			if(pg_close($this->db_connection))
			{
				$this->db_connection = null;
				return true;
			}
		}

		return false;
	}

	public function __destruct()
	{
		$this->disconnect();
	}
}
