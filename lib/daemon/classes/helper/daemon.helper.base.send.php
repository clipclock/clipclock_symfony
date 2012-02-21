<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 10.11.11
 * Time: 16:27
 * To change this template use File | Settings | File Templates.
 */
 
class daemonHelperBaseSend {

	public function __construct()
	{
	}

	public function getImage($url, $args = array())
	{
		$image = imagecreatefromstring($this->retrieveFromUrl($url, $args));

		if(!$image)
		{
			throw new daemonExceptionConnection('Looks like its not image: '.$url);
		}

		return $image;
	}

	protected function retrieveFromUrl($url, $args)
	{
		$ch = curl_init();
		$url = trim($url);

		$result = $this->sendViaGET($url, $ch);

		$get_info = curl_getinfo($ch);

		if(curl_errno($ch) == CURLE_URL_MALFORMAT)
		{
			throw new daemonExceptionLogic(curl_error($ch));
		}
		elseif(curl_errno($ch) || !$result)
		{
			throw new daemonExceptionConnection(curl_error($ch));
		}
		elseif($get_info['http_code'] != 200)
		{
			throw new daemonExceptionConnection('Bad http code, '.$get_info['http_code']);
		}

		curl_close($ch);

		return $result;
	}

	protected function sendViaGET($prepared_url, &$ch)
	{
		curl_setopt($ch, CURLOPT_URL, $prepared_url);
		return $this->sendCurl($ch);
	}

	protected function sendCurl(&$ch)
	{
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13");

		return curl_exec($ch);
	}
}
