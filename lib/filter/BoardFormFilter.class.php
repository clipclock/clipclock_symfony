<?php

/**
 * Board filter form.
 *
 * @package    videopin
 * @subpackage filter
 * @author     Your name here
 */
class BoardFormFilter extends BaseBoardFormFilter
{
	public function configure()
	{
		unset($this['is_public']);
		unset($this['board_follower_list']);
		unset($this['scene_repost_list']);
		$this->setWidget('sf_guard_user_profile_id', new sfWidgetFormFilterInput(array('with_empty' => false)));
		$this->setValidator('sf_guard_user_profile_id', new sfValidatorPass(array('required' => false)));
	}

	public function getFields()
	{
		return array(
			'sf_guard_user_profile_id' => 'Number',
			'name'                 => 'Text',
			'board_refs_category_list' => 'ManyKey',
		);
	}
}
