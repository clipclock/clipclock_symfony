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
		$this->current_user = $this->getVar('current_user');
		$this->user = $this->getVar('user');
		$this->pager->init();
		$this->results = $this->pager->getResults()->fetchAll(PDO::FETCH_ASSOC);
		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));
		//var_dump(url_for('board_page', array('id' => $this->current_board->getId(), 'username_slug' => $this->current_user->getNick(), 'page' => $this->pager->getNextPage())));die();
	}

	public function executeFilterForm()
	{
		$this->user = $this->getVar('current_user');
		$this->form = $this->getVar('form');
	}
}
