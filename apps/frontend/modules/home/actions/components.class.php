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
		$this->pager = $this->getVar('pager');
		$this->pager->init();
		$this->results = $this->pager->getResults()->fetchAll(PDO::FETCH_ASSOC);
		$this->getContext()->getConfiguration()->loadHelpers(array('comment'));
	}

	public function executeFilterForm()
	{
		$this->form = new HomeFilterForm();
	}
}
