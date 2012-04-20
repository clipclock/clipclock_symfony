<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 19.04.12
 * Time: 14:43
 * To change this template use File | Settings | File Templates.
 */
class ClipSaver
{
	public static function saveReclip(Clip $clip, $user_id)
	{
		$reclip = new Reclip();
		$reclip->setClipId($clip->getId());
		$reclip->setSfGuardUserProfileId($user_id);

		if($clip->getClipSocialInfo())
		{
			$ext_user_follower = new ExtUserFollower();
			$ext_user_follower->setFollowingExtUserId($clip->getClipSocialInfo()->getExtUserId());
			$ext_user_follower->setFollowerSfGuardUserProfileId($user_id);
			try{
				$ext_user_follower->save();
			}
			catch(PropelException $e)
			{
				//Фолловер уже есть
			}
		}
		$reclip->save();

		return $reclip;
	}

	public static function saveClip($clip_url, $source_name, $social_info = null, $source_id = null)
	{
		$url = "http://gdata.youtube.com/feeds/api/videos/". $clip_url;
		$doc = new DOMDocument;
		$load_result = $doc->load($url);

		if($load_result)
		{
			$clip_name = $doc->getElementsByTagName("title")->item(0)->nodeValue;
			$clip_duration = $doc->getElementsByTagNameNS("http://gdata.youtube.com/schemas/2007", "duration")->item(0)->getAttribute('seconds');

			if(!$source_id)
			{
				$source = SourcePeer::retrieveByName($source_name);
				$source_id = $source['id'];
			}

			$clip = ClipPeer::retrieveByUrlAndSourceId($clip_url, $source_id);

			if(!$clip)
			{
				$clip = new Clip();
				$clip->setUrl($clip_url);
				$clip->setName($clip_name);
				$clip->setSourceId($source_id);
				$clip->setDuration($clip_duration);

				if(is_array($social_info))
				{
					$provider = ProviderQuery::create()->findOneByName($social_info['provider']);
					$ext_user = ExtUserQuery::create()->filterByProvider($provider)->findOneByExtId($social_info['ext_user_id']);
					$clip_social = null;

					if($ext_user)
					{
						$clip_social = ClipSocialInfoQuery::create()->filterByPostId($social_info['post_id'])->findOneByExtUserId($ext_user->getId());
					}

					if(!$clip_social)
					{
						$clip_social = new ClipSocialInfo();
						$clip_social->setCreatedAt($social_info['created_at']);
						$clip_social->setDescription($social_info['description']);
						$clip_social->setPostId($social_info['post_id']);

						if(!$ext_user)
						{
							$ext_user = new ExtUser();
							$ext_user->setProvider($provider);
							$ext_user->setNick($social_info['ext_user_nick']);
							$ext_user->setExtId($social_info['ext_user_id']);
							$ext_user->save();
						}

						$clip_social->setExtUserId($ext_user->getId());
						$clip_social->save();
					}
					$clip->setClipSocialInfo($clip_social);
				}
				$clip->save();
			}

			return $clip;
		}
		else{
			throw new Exception('Undefined youtube video');
		}
	}
}
