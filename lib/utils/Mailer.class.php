<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 09.02.12
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */

class Mailer {

	const REG_USER_WELCOME = 1;

	protected $subjects = array(
		self::REG_USER_WELCOME                =>  'Welcome to Viddii.com',
	);

	protected $templates = array(
		self::REG_USER_WELCOME                =>  'reg_user_welcome',
	);

	protected $sender_email;
	protected $sender_name;
	protected $context;

	public function __construct(sfContext $context) {
		$this->context = $context;

		$this->sender_email = sfConfig::get('app_registration_robot_email', '');
		$this->sender_name = sfConfig::get('app_registration_robot_name', '');
	}

	public function send($recipient, $const, $attribs = array())
	{
		$mailer = $this->context->getMailer();

		$message = $mailer->compose(array($this->sender_email => $this->sender_name), $recipient, $this->getSubject($const));
		$message->setBody($this->getBody($const, $attribs), 'text/html');
		return $mailer->send($message);
	}

	protected function getBody($const, $attribs = null)
	{
		$view = new sfPartialView(sfContext::getInstance(), 'static', 'index', '');

		$view->setTemplate('email/' . $this->templates[$const] . '.php');

		if (!is_null($attribs) && is_array($attribs)) {
			foreach($attribs as $key => $value) {
				$view->setAttribute($key, $value);
			}
		}

		return $view->render();
	}

	protected function getSubject($const)
	{
		return $this->subjects[$const];
	}
}