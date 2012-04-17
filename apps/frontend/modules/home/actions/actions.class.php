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

	protected function checkLanding()
	{
		if(is_null($this->new_user))
		{
			$this->new_user =
					$this->getContext()->getRouting()->getCurrentRouteName() == 'homepage_modal'
					&& $this->getUser()->getAttribute('new_user') ? true : false;
		}

		if($this->getUser()->getId() && $this->getContext()->getRouting()->getCurrentRouteName() != 'homepage_modal')
		{
			$this->getUser()->setAttribute('new_user', false);
		}

		return $this->new_user;
	}
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->search_string = null;
		if($this->checkLanding() && !$this->getUser()->getAttribute('categories', null) && $this->getUser()->getProfile())
		{
			$this->source = HomeFilterForm::I_FOLLOW_ID;
			//Временное решение
			$this->categories = array(HomeFilterForm::ALL_CATEGORIES_ID);
			$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId(null, $this->getUser()->getId(), $this->categories);
			$this->criteria = SceneTimePeer::modifyCriteriaByFilter($this->criteria, $this->getUser()->getId());
			$count = SceneTimePeer::doCountForPager($this->criteria);
			//Хватает ли элементов из i follow для вывода одной страницы?
			if($count['count'] < 40 / 4)
			{
				//Не хватает
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
				//Завершение процесса и редирект на страницу просмотра всего контента с выборкой по предустановленным категориям
			}
			else
			{
				//Хватает, обнуляем список категорий и выводим все из i follow
				$this->getResponse()->setCookie('source', $this->source);
				$this->getResponse()->setCookie('categories', null);
			}
		}
		else
		{
			if($request->getParameter('search_string'))
			{
				$this->search_string = $request->getParameter('search_string');
			}

			if($this->getUser()->hasAttribute('source'))
			{
				$this->source = $this->getUser()->getAttribute('source');
				$this->categories = $this->getUser()->hasAttribute('categories') ? @unserialize($this->getUser()->getAttribute('categories')) : null;

				$this->getResponse()->setCookie('source', $this->source);
				$this->getResponse()->setCookie('categories', $this->categories ? base64_encode(serialize($this->categories)) : null);
			}
			else
			{
				$this->source = $this->getRequest()->getCookie('source');
				$this->categories = @unserialize(base64_decode($this->getRequest()->getCookie('categories'))) ? @unserialize(base64_decode($this->getRequest()->getCookie('categories'))) : null;
			}
		}

		$this->current_url = $request->getUri();

		// for modal link [homepage_modal]

		$this->modal = 0;

		if ($request->getParameter('modal'))
		{
			$this->modal = 1;
			$this->scene_id = $request->getParameter('scene_id');
			$this->bug_current_url = $this->generateUrl('homepage');
		}

		$this->user = $this->getUser();

		$this->criteria = SceneTimePeer::retrieveClipsIdsForMainByUserId(null, $this->user->getId(), $this->categories);

		$this->page = $request->getParameter('page', 1);
		$this->next_url = $this->generateUrl('homepage_page', array('page' => $this->page+1));
		if($this->source && $this->source == HomeFilterForm::I_FOLLOW_ID)
		{
			$this->criteria = SceneTimePeer::modifyCriteriaByFilter($this->criteria, $this->user->getId(), $this->search_string ? false : true);
		}

		if($this->search_string)
		{
			$this->criteria = SceneTimePeer::modifyCriteriaBySearchFilter($this->criteria, $this->search_string);
			$this->next_url = $this->generateUrl('homepage_search_page', array('search_string' => $this->search_string, 'page' => $this->page+1));
		}

		$this->post_facebook = $request->getCookie('post_facebook', true);

		$this->error = false;
		if($this->getUser()->getFlash('registration_error'))
		{
			$this->error = $this->getUser()->getFlash('registration_error');
		}

		$this->welcome_close = (bool)$request->getCookie('welcome-close');

		$this->categories = $this->categories ? array_flip($this->categories) : null;

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('home', 'clipList', array('criteria' => $this->criteria, 'next_url' => $this->next_url, 'page' => $this->page, 'current_user' => $this->user, 'source' => $this->source, 'categories' => $this->categories, 'sf_cache_key' => $this->user->getId().$this->page.md5($this->criteria->toString()))));
		}
	}

	public function executeBindForm(sfWebRequest $request)
	{
		$this->form = new HomeFilterForm(null, array('user' => $this->getUser()));
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

		if($this->form->getValue('search'))
		{
			$this->redirect($this->generateUrl('homepage_search', array('search_string' => $this->form->getValue('search'))));
		}
		$this->redirect($this->generateUrl('homepage'));
		return sfView::NONE;
	}

	public function executeRedirectToScene(sfWebRequest $request)
	{
		// we use this action just for IE redirect from homepage_modal

		$scene = SceneQuery::create()
				->joinWith('SfGuardUserProfile')
				->filterById($request->getParameter('scene_id'))
				->findOne();

		$this->forward404Unless($scene);

		$this->redirect(
			$this->generateUrl('scene', array(
				'username_slug' => $scene->getSfGuardUserProfile()->getNick(),
				'board_id' => $scene->getBoardId(),
				'id' => $scene->getId()
			))
		);
	}


	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}
}
