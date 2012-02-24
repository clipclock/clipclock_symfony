<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */
class staticComponents extends sfComponents
{
	public function executeAuthPanel()
	{

	}

	public function executeClipForm()
	{
		$this->form = new NewClipForm();
	}

	public function executeAuthForm()
	{
		$this->user = $this->getVar('user');
		$this->user_image = ImagePreview::c14n($this->user->getId(), 'tiny', 'avatar');
	}
}
