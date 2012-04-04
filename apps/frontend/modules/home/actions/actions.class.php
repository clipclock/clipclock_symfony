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
		if($this->getUser()->getAttribute('new_user'))
		{
			$this->getUser()->setAttribute('new_user', false);
			$this->source = HomeFilterForm::I_FOLLOW_ID;
			//Временное решение
			$this->categories = array(HomeFilterForm::ALL_CATEGORIES_ID);
			$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId(null, $this->getUser()->getId(), $this->categories);
			$this->criteria = SceneTimePeer::modifyCriteriaByFilter($this->criteria, $this->getUser()->getId());
			$count = SceneTimePeer::doCountForPager($this->criteria);
			if($count['count'] < 40 / 4)
			{
				$categories_names = array('Dance', 'Events', 'Films & Movies', 'Fitness', 'Recipes', 'People', 'Serials', 'Style', 'Travel & Places');
				if($this->getUser()->getProfile()->getGender())
				{
					$categories_names = array('Business', 'Cars & Motorcycles', 'Education', 'Films & Movies', 'Music', 'News', 'Sports', 'Technology');
				}

				$categories_ids = array();
				foreach($categories_names as $category_name)
				{
					$cat = CategoryQuery::create()->findOneByName($category_name);
					if($cat)
					{
						$categories_ids[] = $cat->getId();
					}
				}

				$this->getUser()->setAttribute('categories', serialize($categories_ids));
				$this->getUser()->setAttribute('source', 1);
				$this->redirect($this->generateUrl('homepage'));
				return sfView::NONE;
			}
			else
			{
				$this->getResponse()->setCookie('source', $this->source);
				$this->getResponse()->setCookie('categories', null);
			}
		}
		else
		{
			if($this->getUser()->getAttribute('source'))
			{
				$this->source = $this->getUser()->getAttribute('source');
				$this->categories = $this->getUser()->getAttribute('categories') ? @unserialize($this->getUser()->getAttribute('categories')) : null;
				if(!$this->categories)
				{
					$this->categories = @unserialize(base64_decode($this->getRequest()->getCookie('categories'))) ? @unserialize(base64_decode($this->getRequest()->getCookie('categories'))) : null;
				}
				$this->getResponse()->setCookie('source', $this->source);
				$this->getResponse()->setCookie('categories', $this->categories ? base64_encode(serialize($this->categories)) : null);
			}
			else
			{
				$this->source = $this->getRequest()->getCookie('source');
				$this->categories = @unserialize(base64_decode($this->getRequest()->getCookie('categories'))) ? @unserialize(base64_decode($this->getRequest()->getCookie('categories'))) : null;
			}
		}

		$this->user = $this->getUser();

		$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId(null, $this->user->getId(), $this->categories);
	}
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		//$this->getUser()->setAttribute('new_user', true);
		$this->post_facebook = $request->getCookie('post_facebook', true);
		if($this->source && $this->source == HomeFilterForm::I_FOLLOW_ID)
		{
			$this->criteria = SceneTimePeer::modifyCriteriaByFilter($this->criteria, $this->user->getId());
		}

		$this->error = false;
		if($this->getUser()->getFlash('registration_error'))
		{
			$this->error = $this->getUser()->getFlash('registration_error');
		}

		$this->welcome_close = (bool)$request->getCookie('welcome-close');

		$this->new_user = false;
		if($this->getUser()->getAttribute('new_user'))
		{
			$this->new_user = $this->getUser()->getAttribute('new_user');
		}
		$this->current_url = $request->getUri();

		$this->page = $request->getParameter('page', 1);

		$this->categories = $this->categories ? array_flip($this->categories) : null;

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('home', 'clipList', array('criteria' => $this->criteria, 'page' => $this->page, 'current_user' => $this->user, 'source' => $this->source, 'categories' => $this->categories)));
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

		/**
		 * Я знаю
		 */

		if($this->form->getValue('categories') == 'all')
		{
			$category_array = null;
		}
		else
		{
			$category_array = array();
			foreach(explode(',', $this->form->getValue('categories')) as $category_id)
			{
				if((int)$category_id && !isset($category_array[$category_id]))
				{
					$category_array[$category_id] = (int)$category_id;
				}
			}

			if(count($category_array))
			{
				if(CategoryQuery::create()->count() <= count($category_array))
				{
					$category_array = null;
				}
			}
		}

		$this->getUser()->setAttribute('source', $this->form->getValue('source'));
		$this->getUser()->setAttribute('categories', serialize($category_array));

		$this->redirect($this->generateUrl('homepage'));
		return sfView::NONE;
	}


	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}
}
