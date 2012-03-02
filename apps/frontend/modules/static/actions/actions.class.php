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

	public function executePreviewNew(sfWebRequest $request)
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

			if($this->clip_url)
			{
				$url = "http://gdata.youtube.com/feeds/api/videos/". $this->clip_url;
				$doc = new DOMDocument;
				$doc->load($url);
				$this->clip_name = $doc->getElementsByTagName("title")->item(0)->nodeValue;
			}

			$source = SourcePeer::retrieveByName($this->source_name);
			$this->source_id = $source['id'];
			//--

			$clip = ClipPeer::retrieveByUrlAndSourceId($this->clip_url, $this->source_id);
			if(!$clip)
			{
				$clip = new Clip();
				$clip->setUrl($this->clip_url);
				$clip->setName($this->clip_name);
				$clip->setSourceId($this->source_id);
				$clip->save();
			}
			else
			{
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

			$this->form = new SceneTimeForm(null, array('reclip_id' => $this->reclip->getId(), 'sf_guard_user_profile_id' => $this->getUser()->getId()));
		}
		else
		{
			$this->getUser()->setFlash('new_clip_form', 'Bad URL!');
			$this->redirect($request->getReferer());
		}
	}
}
