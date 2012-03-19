<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 19.03.12
 * Time: 11:37
 * To change this template use File | Settings | File Templates.
 */
class BackendClipForm extends BaseClipForm
{
	public function setup()
	{
		parent::setup();
		unset($this['clip_follower_list']);
		$this->widgetSchema->setLabel('url', 'Код');
		$this->widgetSchema->setLabel('name', 'Название ролика');
		$this->widgetSchema->setLabel('source_id', 'Источник');
	}
}
