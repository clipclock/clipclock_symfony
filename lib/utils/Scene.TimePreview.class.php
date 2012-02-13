<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 0:42
 * To change this template use File | Settings | File Templates.
 */
class SceneTimePreview
{
	static $step = 2;
	static $prefixes_sizes = array(
		'big' => '/uploads/100/',
		'medium' => '/uploads/70/',
		'small' => '/uploads/61/',
	);

	public static function c14n($scene_id, $size = 'big')
	{
		$scene_hash = md5($scene_id);

		if(!isset(self::$prefixes_sizes[$size]))
		{
			throw new LogicException('Undefined size: ' . $size);
		}

		$path_part = self::$prefixes_sizes[$size];

		for($i = 0; $i < strlen($scene_hash); $i = $i + self::$step)
		{
			$path_part = $path_part . substr($scene_hash, $i, self::$step) . '/';
		}

		return $path_part . $scene_hash . '.jpg';
	}

	public static function c14nArray(array $array, $size = 'big', $id_key = 'id')
	{
		$return_paths = array();

		foreach($array as $value)
		{
			$return_paths[$value[$id_key]] = self::c14n($value[$id_key], $size);
		}

		return $return_paths;
	}

	public static function c14nArrayObjects(array $array, $size = 'big', $id_getter = 'getId')
	{
		$return_paths = array();

		foreach($array as $value)
		{
			$return_paths[$value->$id_getter()] = self::c14n($value->$id_getter(), $size);
		}

		return $return_paths;
	}
}
