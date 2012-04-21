<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */
class homeComponents extends sfComponents
{
	public function executeClipList()
	{
		$this->pager = new sfPropelPager('SceneTime', 40);
		$this->pager->setCriteria($this->getVar('criteria'));
		$this->pager->setPeerMethod('doSelectStmt');
		$this->pager->setPage($this->getVar('page', 1));

		$this->current_user = $this->getVar('current_user');
		$this->user = $this->getVar('user');
		$this->next_url = $this->getVar('next_url');
		$this->pager->init();
		$this->results = $this->pager->getResults()->fetchAll(PDO::FETCH_ASSOC);
	}

	public function executeFilterForm()
	{
		$this->user = $this->getVar('current_user');
		$this->categories = $this->getVar('categories');

		if(!$this->categories)
		{
			$this->categories_selected_text = 'All';
			$this->categories = array();
		}
		elseif(count($this->categories) > 1)
		{
			$this->categories_selected_text = 'My set';
		}
		else
		{
			$this->categories_selected_text = CategoryQuery::create()->findOneById(current(array_flip($this->categories)))->getName();
		}

		$this->form = new HomeFilterForm(null, array('user' => $this->user));
		$this->form->setDefault('source', $this->getVar('source') ? $this->getVar('source') : 1);
		$this->form->setDefault('categories', implode(',', $this->categories));
		if($this->getVar('search_string'))
		{
			$this->form->setDefault('search', $this->getVar('search_string'));
		}
	}

	public function executeCategoriesSelector()
	{
		$this->categories = $this->getVar('categories');

		$this->all_categories = CategoryQuery::create()->orderByName()->find();
	}
}
