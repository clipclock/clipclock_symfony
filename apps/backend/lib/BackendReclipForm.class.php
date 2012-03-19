<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 19.03.12
 * Time: 11:37
 * To change this template use File | Settings | File Templates.
 */
class BackendReclipForm extends BaseReclipForm
{
	public function setup()
	{
		parent::setup();
		unset($this['clip_id']);
		$this->embedForm('clip', new BackendClipForm($this->getObject()->getClip()));
		$this->widgetSchema->setLabel('clip', ' ');
	}
}
