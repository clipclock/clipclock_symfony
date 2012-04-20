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

	public function preExecute()
	{
		$this->current_url = $this->getRequest()->getUri();
	}

	public function executeConnect(sfWebRequest $request)
	{
		if($request->getParameter('scene_id'))
		{
			if($request->getParameter('campaign'))
			{
				$this->getUser()->setAttribute('campaign', $request->getParameter('campaign'));
			}
			$this->getUser()->setAttribute('scene_id', $request->getParameter('scene_id'));
		}

		$this->getUser()->setAttribute('auth_redirect_url', $request->getReferer());

		$this->getUser()->connect('facebook');
		return sfView::NONE;
	}

	public function executeInvites(sfWebRequest $request)
	{
		$user_id = $this->getUser()->getId();
		$timestamp = date('Y-m-d H:i:s');
		$result = $request->getParameter('result');

		$amqp_publisher = new AMQPPublisher();
		$invites_ids = array();
		foreach($result['to'] as $invited_id)
		{
			if(count($invites_ids) < 30)
			{
				$invites_ids[] = $invited_id;
			}
			else
			{
				$amqp_publisher->jobInvites($invites_ids, $user_id, $timestamp);
				$invites_ids = array();
			}
		}

		if(count($invites_ids))
		{
			$amqp_publisher->jobInvites($invites_ids, $user_id, $timestamp);
		}

		return $this->returnJSON(array('success' => true));
	}

	public function executeWelcome(sfWebRequest $request)
	{
		if($this->getUser()->getAttribute('melody') && $this->getUser()->getId())
		{
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

		if($this->getUser()->getAttribute('scene_id'))
		{
			$scene_id = $this->getUser()->getAttribute('scene_id');
			$campaign = $this->getUser()->getAttribute('campaign');
			$this->getUser()->getAttributeHolder()->remove('scene_id');

			//For user who go from external ads
			$this->redirect($this->generateUrl('homepage_modal', array('scene_id' => $scene_id, 'campaign' => $campaign)));
			return sfView::NONE;
		}
		// for users who go from homepage_modal
		// redirect them to homepage_modal back
		$routeData = $this->getContext()->getRouting()->findRoute(
			str_replace($this->generateUrl('homepage', array(), true), '', $request->getReferer()));

		if ($routeData && $routeData['name'] == 'homepage_modal')
		{
			$this->redirect($request->getReferer());
			return sfView::NONE;
		}

		$this->redirect('@homepage');
		return sfView::NONE;
	}

	public function executeRegister(sfWebRequest $request)
	{
		$user_profile = unserialize($this->getUser()->getAttribute('melody_user_profile'));
		$user = unserialize($this->getUser()->getAttribute('melody_user'));
		$melody = unserialize($this->getUser()->getAttribute('melody'));

		if($user->getUsername())
		{
			$user = ProfileMapper::mapFrom($user, $user_profile, $melody);

			if(sfConfig::get('app_registration_invites', 'false'))
			{
				$invite = InvitesPeer::retrieveNewestByExtId(ProfileMapper::getExtId($melody));
				if(!$invite)
				{
					$this->getUser()->setFlash('registration_error', 'no_invite');
					$this->redirect($this->generateUrl('homepage'));
					return sfView::NONE;
				}

				$user->setRefUserId($invite->getSfGuardUserProfileId());
			}

			$user->save();

			$access_token = $melody->getToken();
			$access_token->setUserId($user->getId());

			ProfileMapper::retrieveAvatarsAndPublish($user, $melody);

			if(!$this->getUser()->isAuthenticated() && $user->getIsActive())
			{
				$this->getUser()->signin($user, sfConfig::get('app_melody_remember_user', true));
			}

			$this->getUser()->addToken($access_token);

			$boards = array('Travel & Places', 'Favorite recipes', 'My style', 'Fitness');
			if($this->getUser()->getProfile()->getGender())
			{
				$boards = array('Sport', 'Business', 'Cars', 'Fun');
			}
			foreach($boards as $name)
			{
				$board = new Board();
				$board->setSfGuardUserProfileId($this->getUser()->getId());
				$board->setName($name);
				$board->save();
			}

			FriendsMapper::mapFrom($melody, $user);
			$this->getUser()->setAttribute('new_user', true);
		}

		$this->forward('user', 'welcome');
		return sfView::NONE;
	}

	/*
	 * Нужно переписать нормально
	 * */
	public function executeBoards(sfWebRequest $request)
	{
		$this->user = $this->getRoute()->getObject();
		$this->current_user = $this->getUser();

		$this->pager = new sfPropelPager('Board', 20);
		$this->pager->setCriteria(BoardPeer::retrieveBoardIdByUserId($this->user->getId()));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('user', 'boards', array('current_user' => $this->current_user, 'pager' => $this->pager, 'user' => $this->user))
			);
		}
	}

	public function executeScenes(sfWebRequest $request)
	{
		$this->user = $this->getRoute()->getObject();
		$this->current_user = $this->getUser();

		$this->pager = new sfPropelPager('Scene', 20);
		$this->pager->setCriteria(ScenePeer::retrieveReclipIdsByUserId($this->user->getId()));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));
		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('user', 'scenes', array('current_user' => $this->current_user, 'pager' => $this->pager, 'user' => $this->user))
			);
		}
	}

	public function executeComments(sfWebRequest $request)
	{
		$this->user = $this->getRoute()->getObject();
		$this->current_user = $this->getUser();

		$this->pager = new sfPropelPager('Scene', 20);
		$this->pager->setCriteria(ScenePeer::retrieveReclipIdsByCommentsUserId($this->user->getId()));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));
		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('user', 'comments', array('current_user' => $this->current_user, 'pager' => $this->pager, 'user' => $this->user))
			);
		}
	}

	public function executeLikes(sfWebRequest $request)
	{
		$this->user = $this->getRoute()->getObject();
		$this->current_user = $this->getUser();

		$this->pager = new sfPropelPager('Scene', 20);
		$this->pager->setCriteria(ScenePeer::retrieveReclipIdsByLikesUserId($this->user->getId()));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));
		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('user', 'likes', array('current_user' => $this->current_user, 'pager' => $this->pager, 'user' => $this->user))
			);
		}
	}

    public function executeFollowUser(sfWebRequest $request)
    {
        echo json_encode(array('result' => (UserFollowerPeer::followUserByFollower($request->getParameter('user_id'), $this->getUser()->getId())) ? 'success' : 'fail'));
        return sfView::NONE;
    }

    public function executeUnfollowUser(sfWebRequest $request)
    {
        echo json_encode(array('result' => (UserFollowerPeer::unfollowUserByFollower($request->getParameter('user_id'), $this->getUser()->getId())) ? 'success' : 'fail'));
        return sfView::NONE;
    }

    public function executeFollowClip(sfWebRequest $request)
    {
        echo json_encode(array('result' => (ClipFollowerPeer::followClipByUser($request->getParameter('clip_id'), $this->getUser()->getId())) ? 'success' : 'fail'));
        return sfView::NONE;
    }

    public function executeUnfollowClip(sfWebRequest $request)
    {
        echo json_encode(array('result' => (ClipFollowerPeer::unfollowClipByUser($request->getParameter('clip_id'), $this->getUser()->getId())) ? 'success' : 'fail'));
        return sfView::NONE;
    }

    public function executeFollowBoard(sfWebRequest $request)
    {
        echo json_encode(array('result' => (BoardFollowerPeer::followBoardByUser($request->getParameter('board_id'), $this->getUser()->getId())) ? 'success' : 'fail'));
        return sfView::NONE;
    }

    public function executeUnfollowBoard(sfWebRequest $request)
    {
        echo json_encode(array('result' => (BoardFollowerPeer::unfollowBoardByUser($request->getParameter('board_id'), $this->getUser()->getId())) ? 'success' : 'fail'));
        return sfView::NONE;
    }

	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}
}
