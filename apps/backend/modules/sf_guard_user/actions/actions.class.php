<?php

require_once dirname(__FILE__).'/../lib/sf_guard_userGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/sf_guard_userGeneratorHelper.class.php';

/**
 * sf_guard_user actions.
 *
 * @package    videopin
 * @subpackage sf_guard_user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class sf_guard_userActions extends autoSf_guard_userActions
{
	public function executeRefreshAvatar(sfWebRequest $request)
	{
		$this->sfGuardUser = $this->getRoute()->getObject();

		ImagePreview::deleteAllImages($this->sfGuardUser->getId(), 'avatar');

		$token = TokenQuery::create()->filterByName('facebook')->findOneByUserId($this->sfGuardUser->getId());
		$melody = sfMelody::getInstance($token->getName(), array('token' => $token));
		$action_map = ProfileMapper::$action_map;
		$photo_action = $action_map[$melody->getName()]['photo'];
		$avatar_action = ProfileMapper::$action_map[$melody->getName()]['avatar'];
		$photo_url = $melody->getPhoto()->$photo_action;
		$avatar_url = $melody->getAvatar()->$avatar_action;

		$amqp_publisher = new AMQPPublisher();
		$amqp_publisher->jobAvatar(
			$this->sfGuardUser->getId(),
			$photo_url,
			$avatar_url);

		$this->getUser()->setFlash('notice', 'The selected avatar have been updated successfully.');

		$this->redirect('@sf_guard_user');
	}
}
