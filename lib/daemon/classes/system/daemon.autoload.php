<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 28.10.11
 * Time: 15:34
 * To change this template use File | Settings | File Templates.
 */
spl_autoload_register(array('daemonAutoload', 'loadClass'), true, true);
class daemonAutoload{

	protected static $valid_types = array(
		'helper', 'exception', 'worker', 'driver', 'model', 'interface'
	);

	public static function loadClass($class)
	{
		if(substr($class, 0, 6) == 'daemon')
		{
			$raw_path = strtolower(preg_replace('/([a-z])([A-Z])/', '$1.$2', $class));
			$path_parts = explode('.', $raw_path);

			$valid_types = array_flip(self::$valid_types);

			if(isset($valid_types[$path_parts[1]]) && $valid_types[$path_parts[1]] >= 0)
			{
				$path = self::$valid_types[$valid_types[$path_parts[1]]] . '/' . $raw_path;
			}
			else
			{
				$path = 'system/' . $raw_path;
			}

			require_once(dirname(__FILE__) . '/../' . $path . '.php');
			unset($path);
			unset($path_parts);
			unset($valid_types);
			unset($raw_path);
			unset($class);
		}

		return false;
	}
}