<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 0:42
 * To change this template use File | Settings | File Templates.
 */
class ImagePreview
{
	static $step = 2;

	static $prefixes_types_sizes = array(
		'scene' => array(
			'big' => '/uploads/scenes/100/',
			'medium' => '/uploads/scenes/70/',
			'small' => '/uploads/scenes/61/',
		),
		'avatar' => array(
			'big' => '/uploads/avatar/100/',
			'medium' => '/uploads/avatar/50/',
			'small' => '/uploads/avatar/30/',
			'tiny' => '/uploads/avatar/21/',
		)
	);

	public static function c14n($scene_id, $size = 'medium', $type = 'scene')
	{
		$scene_hash = md5($scene_id);

		if(!isset(self::$prefixes_types_sizes[$type][$size]))
		{
			throw new LogicException('Undefined size: ' . $size);
		}

		$path_part = self::$prefixes_types_sizes[$type][$size];

		for($i = 0; $i < strlen($scene_hash); $i = $i + self::$step)
		{
			$path_part = $path_part . substr($scene_hash, $i, self::$step) . '/';
		}

		return $path_part . $scene_hash . '.jpg';
	}

	public static function c14nArray(array $array, $size = 'medium', $id_key = 'id', $type = 'scene')
	{
		$return_paths = array();

		foreach($array as $value)
		{
			$return_paths[$value[$id_key]] = self::c14n($value[$id_key], $size);
		}

		return $return_paths;
	}

	public static function c14nArrayObjects(array $array, $size = 'medium', $id_getter = 'getId', $type = 'scene')
	{
		$return_paths = array();

		foreach($array as $value)
		{
			$return_paths[$value->$id_getter()] = self::c14n($value->$id_getter(), $size);
		}

		return $return_paths;
	}
}
