<?php

/**
 * Scene form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class BackendSceneForm extends BaseSceneForm
{
	public function configure()
	{
		parent::setup();
		unset($this['scene_like_list']);
		unset($this['scene_repin_list']);
		unset($this['scene_repost_list']);
	}
}
