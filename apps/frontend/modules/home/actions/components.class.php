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
		$this->pager->init();
		$this->results = $this->pager->getResults()->fetchAll(PDO::FETCH_ASSOC);
	}

	public function executeFilterForm()
	{
		$this->user = $this->getVar('current_user');

		$this->form = new HomeFilterForm(null, array('user' => $this->user));
		$this->form->setDefault('source', $this->getVar('source'));
		$this->form->setDefault('category', $this->getVar('category'));
	}
}
