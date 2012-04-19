<?php

/**
 * static actions.
 *
 * @package    videopin
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward('default', 'module');
	}

	public function executeError404(sfWebRequest $request)
	{
		$this->setLayout(false);
	}

	public function executePreviewNew(sfWebRequest $request)
	{
		$clip = null;
		if($request->getParameter('clip_id'))
		{
			$clip = ClipPeer::retrieveByPK($request->getParameter('clip_id'));
		}

		if($clip)
		{
			$this->clipRoutine($clip);
		}
		else
		{
			$this->form = new NewClipForm();

			$this->form->bind($request->getParameter($this->form->getName()));
			if($this->form->isValid() && $this->getUser()->getId())
			{
				$this->source_name = 'youtube';
				//Into util or helper
				$url = parse_url($this->form->getValue('url'));
				foreach(explode('&', $url['query']) as $params)
				{
					$values = explode('v=', $params);
					if(count($values) > 1)
					{
						$this->clip_url = $values[1];
						break;
					}
				}

				$clip = ClipSaver::saveClip($this->clip_url, $this->source_name);

				$this->clipRoutine($clip);
			}
			elseif(!$this->getUser()->getId())
			{
				$this->getUser()->setFlash('new_clip_form', 'Please login to the service!');
				$this->redirect($request->getReferer());
			}
			else
			{
				$this->getUser()->setFlash('new_clip_form', 'Bad URL!');
				$this->redirect($request->getReferer());
			}
		}
	}

	protected function clipRoutine($clip)
	{
		$this->source_name = 'youtube';
		$this->clip_url = $clip->getUrl();
		$this->clip_name = $clip->getName();
		$scene = ScenePeer::retrieveYoungestByClipId($clip->getId());
		if($scene)
		{
			$this->redirect($this->generateUrl('scene', array(
				'username_slug' => $scene->getSfGuardUserProfile()->getNick(),
				'board_id' => $scene->getBoardId(),
				'id' => $scene->getId()
			)));
			return sfView::NONE;
		}

		$this->clip = $clip;

		$reclip = ReclipPeer::retrieveByClipIdUserId($clip->getId(), $this->getUser()->getId());
		if(!$reclip)
		{
			$reclip = new Reclip();
			$reclip->setClipId($this->clip->getId());
			$reclip->setSfGuardUserProfileId($this->getUser()->getId());
			$reclip->save();
		}
		$this->reclip = $reclip;

		$this->post_facebook = $this->getRequest()->getCookie('post_facebook', true);
		$this->form = new SceneTimeForm(null, array('reclip_id' => $this->reclip->getId(), 'sf_guard_user_profile_id' => $this->getUser()->getId()));
	}

	public function executeFacebookCanvas(sfWebRequest $request)
	{
		$this->setLayout(false);
		$this->url = $this->generateUrl('connect_fb');
		if($this->getRequest()->getParameter('fb_source') && ($this->getRequest()->getParameter('fb_source') == 'notification' ||
				($this->getRequest()->getParameter('fb_source') == 'bookmark_apps' && $this->getRequest()->getParameter('count') > 0)))
		{
			$this->getResponse()->setCookie('fb_notifications', 'true');
		}
	}
}
