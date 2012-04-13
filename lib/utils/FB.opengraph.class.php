<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 09.02.12
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */

class FBopengraph {

	protected $browser = null;
	protected $access_token = '';

	protected $namespace = '';
	protected $provider = '';

	protected $action_urls = array(
		'facebook' => array(
			'create' => 'https://graph.facebook.com/me/%namespace%:create'
		)
	);

	public function __construct($user, $provider) {
		$this->browser = new sfWebBrowser();
		$this->access_token = $user->getMelody($provider)->getToken($provider)->getTokenKey();

		$fb = sfConfig::get('app_melody_'.$provider);
		$this->namespace = $fb['namespace'];
		$this->provider = $provider;

		if(!isset($this->action_urls[$provider]))
		{
			return false;
		}

		foreach($this->action_urls[$provider] as $key => &$action_url)
		{
			$action_url = str_ireplace('%namespace%', $this->namespace, $action_url);
		}
	}

	public function postCreate($url, $logger = null)
	{
		$action_url = $this->getActionUrl('create');
		if(!$action_url)
		{
			return false;
		}

		$result = $this->browser->post($action_url, array(
			'access_token' => $this->access_token,
			'clip' => $url//'http://www.youtube.com/v/'.$source.'?enablejsapi=1&playerapiid=ytplayer&start='.$scene_time.'&autoplay=1&version=3&feature=player_embedded&fs=1&rel=0&showsearch=0&showinfo=0'
			/*'link' => $url,
			'name' => $name,
			'source' => 'http://www.youtube.com/v/'.$source.'?enablejsapi=1&playerapiid=ytplayer&start='.$scene_time.'&autoplay=1&version=3&feature=player_embedded&fs=1&rel=0&showsearch=0&showinfo=0',
			'picture' => 'http://clipclock.com'.ImagePreview::c14n($clip_id.$scene_time, 'big')*/
		))->getResponseText();

		if($logger)
		{
			$logger->log(var_export($this->access_token, true), 0, 'warning');
			$logger->log(var_export($url, true), 0, 'warning');
			$logger->log(var_export($result, true), 0, 'warning');
		}

		$result = json_decode($result);

		if(!isset($result->id))
		{
			return false;
		}

		return $result->id;
	}

	protected function getActionUrl($action)
	{
		return isset($this->action_urls[$this->provider][$action]) ? $this->action_urls[$this->provider][$action] : false;
	}

}