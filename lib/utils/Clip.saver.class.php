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
	public static function saveReclip($clip_id, $user_id, $fb_user_id = null, $fb_post_id = null)
	{
		$reclip = new Reclip();
		$reclip->setClipId($clip_id);
		$reclip->setSfGuardUserProfileId($user_id);

		if($fb_user_id && $fb_post_id)
		{
			$reclip->setFbUserId($fb_user_id);
			$reclip->setFbPostId($fb_post_id);

			$fb_user_follower = new FbUserFollower();
			$fb_user_follower->setFollowerSfGuardUserProfileId($user_id);
			$fb_user_follower->setFollowingFbUserId($fb_user_id);
			try{
				$fb_user_follower->save();
			}catch(PropelException $e)
			{
			}
		}
		$reclip->save();

		return $reclip;
	}

	public static function saveClip($clip_url, $source_name, $source_id = null)
	{
		$url = "http://gdata.youtube.com/feeds/api/videos/". $clip_url;
		$doc = new DOMDocument;
		$doc->load($url);
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
			$clip->save();
		}

		return $clip;
	}
}
