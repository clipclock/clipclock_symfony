<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */
class listComponents extends sfComponents
{
	public function executeItemsList()
	{
		$this->pager = $this->getVar('pager');
		$this->current_user = $this->getVar('current_user');
		$this->pager->init();
		$this->results = $this->pager->getResults()->fetchAll(PDO::FETCH_ASSOC);
	}

	public function executeItem()
	{
		$this->current_user = $this->getVar('current_user');
		$this->user_id = $this->getVar('user_id');

		$this->scene_infos = ScenePeer::retrieveLatestByUserId($this->user_id);
	}
}
