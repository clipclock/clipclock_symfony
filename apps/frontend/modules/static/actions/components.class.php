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
		$user = $this->getVar('user');
		$this->form = new NewClipForm();

		if($user && $user->getFlash('new_clip_form', ''))
		{
			$this->form->setDefault('url', $user->getFlash('new_clip_form'));
		}
	}

	public function executeAuthForm()
	{
		$this->user = $this->getVar('user');
		$this->user_image = ImagePreview::c14n($this->user->getId(), 'tiny', 'avatar');

		$fb = sfConfig::get('app_melody_facebook');
		$this->fb_app_id = $fb['key'];

		$fb_page = sfConfig::get('app_facebook_page');
		$this->fb_page_url = $fb_page;
	}
}
