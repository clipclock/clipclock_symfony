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


	protected function checkType()
	{
		$valid_types = array_flip(SfGuardUserProfilePeer::$objects_types);

		if(!isset($valid_types[$this->getRequest()->getParameter('type')]))
		{
			$this->forward404();
		}
		else
		{
			$this->type_id = $valid_types[$this->getRequest()->getParameter('type')];
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
		$this->type = SfGuardUserProfilePeer::$objects_types_names[$this->type_id];
		$this->current_user = $this->getUser();

		$this->forward404Unless($this->object);

		$this->pager = new sfPropelPager('SfGuardUserProfile', 16);
		$this->pager->setCriteria(SfGuardUserProfilePeer::retrieveCriteriaForListingByObjectIdAndTypeId($this->object->getId(), $this->type_id));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('board', 'boardClipsList', array('current_board' => $this->current_board, 'pager' => $this->pager, 'current_user' => $this->current_user))
			);
		}
	}
}
