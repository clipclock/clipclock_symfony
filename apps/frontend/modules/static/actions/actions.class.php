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
		if($this->form->isValid())
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

			$this->source_id = 18;
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
			$this->clip = $clip;

			$scene = ScenePeer::retrieveYoungestByClipId($clip->getId());
			if($scene)
			{
				$this->redirect($this->generateUrl('scene', array(
					'username_slug' => $scene->getSfGuardUserProfile()->getNick(),
					'board_id' => $scene->getBoardId(),
					'id' => $scene->getId()
				)));
			}

			$this->form = new SceneTimeForm(null, array('clip_id' => $this->clip->getId()));
		}
	}
}
