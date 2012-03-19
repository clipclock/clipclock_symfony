<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 19.03.12
 * Time: 11:37
 * To change this template use File | Settings | File Templates.
 */
class BackendSceneTimeForm extends BaseSceneTimeForm
{
	public function setup()
	{
		parent::setup();
		unset($this['created_at']);
		unset($this['reclip_id']);
		unset($this['unique_comments_count']);
		$this->embedForm('reclip', new BackendReclipForm($this->getObject()->getReclip()));
		$this->widgetSchema->setLabel('reclip', ' ');
		$this->widgetSchema->setLabel('scene_time', 'Время сцены');
	}
}
