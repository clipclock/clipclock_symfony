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
			'post' => 'https://graph.facebook.com/me/feed'
		)
	);

	public function __construct($user) {
		$this->browser = new sfWebBrowser();
		$this->access_token = $user->getMelody('facebook')->getToken('facebook')->getTokenKey();
	}

	public function postLink($url)
	{
		$result = $this->browser->post($this->urls['facebook']['post'], array(
			'access_token' => $this->access_token,
			'link' => 'http://clipclock.com/madesst/board/50/scene/2448'
		))->getResponseText();

		$result = json_decode($result);

		if(!isset($result->id))
		{
			return false;
		}

		return $result->id;
	}

}