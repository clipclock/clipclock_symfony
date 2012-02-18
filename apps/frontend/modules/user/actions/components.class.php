<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */
class userComponents extends sfComponents
{
	public function executeInfo()
	{
		$this->user = $this->getVar('user');
		$this->ext_profiles = $this->user->getExtProfiles();
		$this->avatar_img = ImagePreview::c14n($this->user->getId(), 'big', 'avatar');
	}

	public function executeFollowersList()
	{
		$this->user = $this->getVar('user');

	}

	public function executeHistory()
	{
		$this->user = $this->getVar('user');
	}

	public function executeBoards()
	{
		$this->user = $this->getVar('user');
	}
}
