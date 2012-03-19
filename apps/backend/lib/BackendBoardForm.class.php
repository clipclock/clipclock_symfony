<?php

/**
 * Scene form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class BackendBoardForm extends BaseBoardForm
{
	public function configure()
	{
		parent::setup();
/*
		$this->embedForm('scene_time', new BackendSceneTimeForm($this->getObject()->getSceneTime()));
		$this->widgetSchema['created_at'] = new sfWidgetFormJQueryDate();

		$c = new Criteria();
		$c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $this->getObject()->getSfGuardUserProfileId());
		$this->setWidget('board_id', new sfWidgetFormPropelChoice(array('model' => 'Board', 'add_empty' => false, 'criteria' => $c)));
		$this->setValidator('board_id', new sfValidatorPropelChoice(array('model' => 'Board', 'column' => 'id', 'criteria' => $c)));
*/
		unset($this['scene_repost_list']);
		unset($this['board_follower_list']);
	}
}
