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
	public function executeMyBoardsList()
	{
		$this->boards = BoardPeer::doSelectByUserId($this->getUser()->getId());
	}
}
