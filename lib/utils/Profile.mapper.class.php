<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 11.02.12
 * Time: 14:18
 * To change this template use File | Settings | File Templates.
 */
 
class ProfileMapper {

	static $provider_map = array(
		'facebook' => 1
	);

	static $action_map = array(
		'facebook' => array(
			'id' => 'id',
			'nickname' => 'name',
			'link' => 'link',
		)
	);

	public static function mapFrom($user, $user_profile, $melody)
	{
		if(!isset(self::$provider_map[$melody->getName()]))
		{
			throw new LogicException('Undefined provider');
		}

		if(!$user_profile->getNick())
		{
			$action = self::$action_map[$melody->getName()]['nickname'];
			$user_profile->setNick($melody->getNickname()->$action);
		}

		$user_ext_profile = new extProfile();

		$action = self::$action_map[$melody->getName()]['id'];
		$user_ext_profile->setExtId($melody->getLink()->$action);
		$action = self::$action_map[$melody->getName()]['link'];
		$user_ext_profile->setExtLink($melody->getLink()->$action);

		$user_ext_profile->setProvider(self::$provider_map[$melody->getName()]);

		$user_ext_profile->setSfGuardUserProfile($user_profile);
		$user_profile->setSfGuardUser($user);

		return $user;
	}
}
