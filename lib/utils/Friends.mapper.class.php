<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 11.03.12
 * Time: 14:07
 * To change this template use File | Settings | File Templates.
 */
class FriendsMapper
{
	protected static $data = array();
	protected static $raw_data = array();
	protected static $next_link_parsed = '&fileds=id';

	public static function mapFrom($melody, $user)
	{
		if(!isset(ProfileMapper::$provider_map[$melody->getName()]))
		{
			throw new LogicException('Undefined provider');
		}

		self::retrieveData($melody);

		$exists_users = UserFollowerPeer::retrieveUserIdsByIdentifiers(self::$data, $melody->getName());
		foreach($exists_users as $exists_user)
		{
			UserFollowerPeer::followUserByFollower($user->getId(), $exists_user['user_id']);
			UserFollowerPeer::followUserByFollower($exists_user['user_id'], $user->getId());
		}
	}

	protected static function retrieveData($melody)
	{
		self::$raw_data = $melody->getMeFriends(self::$next_link_parsed)->data;
		self::parseData($melody);

		if(self::$raw_data)
		{
			self::retrieveData($melody);
		}
	}

	protected static function parseData($melody)
	{
		if(self::$raw_data)
		{
			foreach(self::$raw_data as $element)
			{
				self::$data[] = $element->id;
			}

			self::$next_link_parsed = '&fileds=id';
			$next_link = $melody->getMeFriends()->paging->next;
			foreach(explode('&', parse_url($next_link, PHP_URL_QUERY)) as $arg_string)
			{
				$arg_string_parsed = explode('=', $arg_string);
				if($arg_string_parsed[0] != 'access_token')
				{
					self::$next_link_parsed = self::$next_link_parsed . '&' . $arg_string_parsed[0] . '=' . $arg_string_parsed[1];
				}

				unset($arg_string_parsed);
			}

			return true;
		}
		else
		{
			return false;
		}
	}
}
