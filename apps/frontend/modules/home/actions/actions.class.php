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
		if($this->getRequest()->getCookie('fb_notifications'))
		{
			$this->getResponse()->setCookie('fb_notifications', '');
			$this->source = HomeFilterForm::I_FOLLOW_ID;
			//Временное решение
			$this->category = HomeFilterForm::ALL_CATEGORIES_ID;
			$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId(null, $this->getUser()->getId(), $this->category);
			$this->criteria = SceneTimePeer::modifyCriteriaByFilter($this->criteria, $this->getUser()->getId());
			$count = SceneTimePeer::doCountForPager($this->criteria);
			if($count['count'] < 40 / 4)
			{
				$this->redirect($this->generateUrl('homepage'));
				return sfView::NONE;
			}
		}
		else
		{
			$this->source = $this->getRequest()->getParameter('source') ? $this->getRequest()->getParameter('source') : $this->getRequest()->getCookie('source');
			$this->category = $this->getRequest()->getParameter('category') != null ? $this->getRequest()->getParameter('category') : $this->getRequest()->getCookie('category');
		}

		$this->user = $this->getUser();


		$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId(null, $this->user->getId(), $this->category);
	}
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->post_facebook = $request->getCookie('post_facebook', true);
		if($this->source && $this->source == HomeFilterForm::I_FOLLOW_ID)
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

		$this->error = false;
		if($this->getUser()->getFlash('registration_error'))
		{
			$this->error = $this->getUser()->getFlash('registration_error');
		}

		$this->welcome_close = (bool)$request->getCookie('welcome_close');

		$this->new_user = false;
		if($this->getUser()->getAttribute('new_user'))
		{
			$this->new_user = $this->getUser()->getAttribute('new_user');
		}
		$this->current_url = $request->getUri();

		$this->page = $request->getParameter('page', 1);

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('home', 'clipList', array('criteria' => $this->criteria, 'page' => $this->page, 'current_user' => $this->user, 'source' => $this->source, 'category' => $this->category)));
		}
	}

	public function executeBindForm(sfWebRequest $request)
	{
		$this->form = new HomeFilterForm(null, array('user' => $this->user));
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
