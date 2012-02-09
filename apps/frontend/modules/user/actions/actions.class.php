<?php

/**
 * user actions.
 *
 * @package    videopin
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */

	public function executeConnect(sfWebRequest $request)
	{
		$this->getUser()->connect('facebook');
		return sfView::NONE;
	}

	public function executeWelcome(sfWebRequest $request)
	{
		if(!$this->getUser()->getAttribute('melody'))
		{
			$this->redirect('@homepage');
		}

		$this->getUser()->getAttributeHolder()->remove('melody');
		$this->getUser()->getAttributeHolder()->remove('melody_user');
		$this->getUser()->getAttributeHolder()->remove('melody_user_profile');

		if(sfConfig::get('app_registration_confirm', 'false'))
		{
			$mailer = new Mailer($this->getContext()->getInstance());
			$mailer->send(
				$this->getUser()->getEmail(),
				Mailer::REG_USER_WELCOME,
				array(
					 'name' => $this->getUser()->getFirstName() ? $this->getUser()->getFirstName() : $this->getUser()->getNick(),
				)
			);
		}
	}

	public function executeRegister(sfWebRequest $request)
	{
		$user_profile = unserialize($this->getUser()->getAttribute('melody_user_profile'));
		$user = unserialize($this->getUser()->getAttribute('melody_user'));
		$melody = unserialize($this->getUser()->getAttribute('melody'));

		$user_profile->setSfGuardUser($user);
		if(!$user_profile->getNick())
		{
			$user_profile->setNick($melody->getNickname()->name);
		}


		$user->save();
		$access_token = $melody->getToken();
		$access_token->setUserId($user->getId());

		if(!$this->getUser()->isAuthenticated() && $user->getIsActive())
		{
			$this->getUser()->signin($user, sfConfig::get('app_melody_remember_user', true));
		}

		$this->getUser()->addToken($access_token);

		$this->redirect('@user_register_welcome');
	}
}
