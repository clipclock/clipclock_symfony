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
			'photo' => 'picture',
			'avatar' => 'picture',
			'gender' => 'gender',
			'country' => 'name',
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
			$action = self::$action_map[$melody->getName()]['id'];
			$user_profile->setNick($melody->getNickname()->$action);
		}

		$user_ext_profile = new extProfile();

		$user_ext_profile->setExtId(self::getExtId($melody));
		$action = self::$action_map[$melody->getName()]['link'];
		$user_ext_profile->setExtLink($melody->getLink()->$action);

		$action = self::$action_map[$melody->getName()]['gender'];
		$user_profile->setGender($melody->getGender()->$action != 'male' ? 0 : 1 );

		$string = $melody->getCountry()->location->name;

		if(strpos($string, ', '))
		{
			$country_city = explode(', ', $string);

			$user_profile->setCity($country_city[0]);
			$user_profile->setCountry($country_city[1]);
		}

		$user_ext_profile->setProvider(self::$provider_map[$melody->getName()]);

		$user_ext_profile->setSfGuardUserProfile($user_profile);
		$user_profile->setSfGuardUser($user);

		if($user->getId())
		{
			self::retrieveAvatarsAndPublish($user, $melody);
		}

		return $user;
	}

	public static function getExtId($melody)
	{
		$action = self::$action_map[$melody->getName()]['id'];
		return $melody->getLink()->$action;
	}

	public static function retrieveAvatarsAndPublish($user, $melody)
	{
		$amqp_publisher = new AMQPPublisher();
		$photo_action = self::$action_map[$melody->getName()]['photo'];
		$avatar_action = self::$action_map[$melody->getName()]['avatar'];
		$amqp_publisher->jobAvatar($user->getId(), $melody->getPhoto()->$photo_action, $melody->getAvatar()->$avatar_action);
	}
}
