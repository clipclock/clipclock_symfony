<?php

/**
 * list actions.
 *
 * @package    videopin
 * @subpackage list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class listActions extends sfActions
{
	const FOLLOWERS = 'followers';
	const FOLLOWINGS = 'followings';
	const SCENE_LIKES = 'scene_likes';
	const SCENE_REPINS = 'scene_repins';
	const SCENE_COMMENTS = 'scene_comments';

	protected function checkType()
	{
		$reflection = new ReflectionClass($this);
		$valid_types = array_flip($reflection->getConstants());

		if(!isset($valid_types[$this->getRequest()->getParameter('type')]))
		{
			$this->forward404();
		}
		else
		{
			$this->type = $valid_types[$this->getRequest()->getParameter('type')];
		}
	}

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward('default', 'module');
	}

	public function executeShowListing(sfWebRequest $request)
	{
		$this->checkType();
		$this->back_url = $request->getReferer();
		$this->object = $this->getRoute()->getObject();

		$this->forward404Unless($this->object);

		$this->pager = new sfPropelPager('SfGuardUserProfile', 16);
		$this->pager->setCriteria(SfGuardUserProfilePeer::retrieveCriteriaForListingByObjectIdAndType($this->object->getId(), $this->type));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('board', 'boardClipsList', array('current_board' => $this->current_board, 'pager' => $this->pager, 'current_user' => $this->current_user))
			);
		}
	}
}
