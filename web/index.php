<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
//
//$env = 'prod';
//if(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))
//{
//	$env = 'dev';
//}
//
//if(isset($_COOKIE['dev']))
//{
//	$cookie_info = unserialize($_COOKIE['dev']);
//	if(isset($cookie_info['key']) && $cookie_info['key'] == '312312')
//	{
//		$env = $cookie_info['env'];
//	}
//}

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);
sfContext::createInstance($configuration)->dispatch();
