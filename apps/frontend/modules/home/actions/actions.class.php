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
	public function preExecute()
	{
		$this->user = $this->getUser();

		$this->form = new HomeFilterForm(null, array('user' => $this->user));
		$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId();
	}
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->source = $request->getParameter('source');
		$this->category = $request->getParameter('category');
		if($request->getParameter('source') && $request->getParameter('source') == 2)
		{
			$this->form->setDefault('source', $request->getParameter('source'));
			$this->form->setDefault('category', $request->getParameter('category'));

			$user_following = UserFollowerPeer::retrieveIdByFollower($this->user->getId());
			$board_following = BoardFollowerPeer::retrieveIdByFollower($this->user->getId());
			$clip_following = ClipFollowerPeer::retrieveIdByFollower($this->user->getId());

			$this->criteria = SceneTimePeer::modifyCriteriaByFilter($this->criteria, $user_following, $board_following, $clip_following, $request->getParameter('category'));
		}

		$this->pager = new sfPropelPager('SceneTime', 24);
		$this->pager->setCriteria($this->criteria);
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('home', 'clipList', array('pager' => $this->pager, 'current_user' => $this->user, 'source' => $this->source, 'category' => $this->category)));
		}
	}

	public function executeBindForm(sfWebRequest $request)
	{
		$this->form->bind($request->getParameter($this->form->getName()));
		$request->getParameter($this->form->getName());

		if(!$this->form->isValid())
		{
			$this->redirect($this->generateUrl('homepage'));
			return sfView::NONE;
		}

		$this->redirect($this->generateUrl('homepage', array('source' => $this->form->getValue('source'), 'category' => $this->form->getValue('category'))));
	}


	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}
}
