<?php

/**
 * SceneComment form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class SceneCommentForm extends BaseSceneCommentForm
{
	public function configure()
	{
		$this->setWidgets(array(
			'reply_to_comment_id'      => new sfWidgetFormInputHidden(),
			'scene_time_id'            => new sfWidgetFormInputHidden(),
			'text'                     => new sfWidgetFormTextarea(),
		));
	}
}
