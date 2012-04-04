<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 09.02.12
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */

class FB {

	protected $browser = null;
	protected $access_token = '';

	protected $urls = array(
		'facebook' => array(
				'post' => 'https://graph.facebook.com/me/links'
		)
	);

	public function __construct($user) {
		$this->browser = new sfWebBrowser();
		$this->access_token = $user->getMelody('facebook')->getToken('facebook')->getTokenKey();
	}

	public function postLink($url, $name, $source, $scene_time, $clip_id)
	{
		$result = $this->browser->post($this->urls['facebook']['post'], array(
			'access_token' => $this->access_token,
			'link' => $url,
			'name' => $name,
			'source' => 'http://www.youtube.com/v/'.$source.'?enablejsapi=1&playerapiid=ytplayer&start='.$scene_time.'&autoplay=1&version=3&feature=player_embedded&fs=1&rel=0&showsearch=0&showinfo=0',
			'picture' => 'http://clipclock.com'.ImagePreview::c14n($clip_id.$scene_time, 'big')
		))->getResponseText();

		$result = json_decode($result);

		if(!isset($result->id))
		{
			return false;
		}

		return $result->id;
	}

}