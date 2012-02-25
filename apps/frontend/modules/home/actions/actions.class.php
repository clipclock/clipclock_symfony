<?php

/**
 * home actions.
 *
 * @package    videopin
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		//$this->forward('default', 'module');
		if($this->getUser()->isAuthenticated())
		{

		}

		$this->pager = new sfPropelPager('SceneTime', 30);
		$this->pager->setCriteria(SceneTimePeer::retrieveClipsIdsForMainByUserId($this->getUser()->getId()));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));
	}
}
