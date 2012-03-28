<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$env = 'prod';
if(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))
{
	$env = 'dev';
}

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', $env, false);
sfContext::createInstance($configuration)->dispatch();
