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
		$this->source = $this->getRequest()->getParameter('source') ? $this->getRequest()->getParameter('source') : $this->getRequest()->getCookie('source');
		$this->category = $this->getRequest()->getParameter('category') != null ? $this->getRequest()->getParameter('category') : $this->getRequest()->getCookie('category');

		$this->user = $this->getUser();

		$this->form = new HomeFilterForm(null, array('user' => $this->user));
		$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId(null, $this->user->getId(), $this->category);
	}
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->form->setDefault('source', $this->source);
		$this->form->setDefault('category', $this->category);

		if($this->source && $this->source == 2)
		{
			$this->criteria = SceneTimePeer::modifyCriteriaByFilter($this->criteria, $this->user->getId());
		}

		if($request->getParameter('source'))
		{
			$this->response->setCookie('source', $request->getParameter('source'));
		}

		if($request->getParameter('category') != null)
		{
			$this->response->setCookie('category', $request->getParameter('category'));
		}

		$this->pager = new sfPropelPager('SceneTime', 40);
		$this->pager->setCriteria($this->criteria);
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));

		$this->error = false;
		if($this->getUser()->getFlash('registration_error'))
		{
			$this->error = $this->getUser()->getFlash('registration_error');
		}

		$this->welcome_close = (bool)$request->getCookie('welcome_close');

		$this->current_url = $request->getUri();
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
