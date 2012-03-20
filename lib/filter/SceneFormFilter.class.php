<?php

/**
 * Scene filter form.
 *
 * @package    videopin
 * @subpackage filter
 * @author     Your name here
 */
class SceneFormFilter extends BaseSceneFormFilter
{
  public function configure()
  {
	  unset($this['scene_like_list']);
	  unset($this['scene_repin_list']);
	  unset($this['scene_repost_list']);
	  unset($this['scene_time_id']);
	  unset($this['text']);

	  $this->setWidget('sf_guard_user_profile_id', new sfWidgetFormFilterInput(array('with_empty' => false)));
	  $this->setWidget('board_id', new sfWidgetFormFilterInput(array('with_empty' => false)));
	  $this->setWidget('repin_origin_scene_id', new sfWidgetFormFilterInput(array('with_empty' => false)));
	  $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormJQueryDate(), 'to_date' => new sfWidgetFormJQueryDate(), 'with_empty' => false)));

	  $this->setValidator('sf_guard_user_profile_id', new sfValidatorPass(array('required' => false)));
	  $this->setValidator('board_id', new sfValidatorPass(array('required' => false)));
	  $this->setValidator('repin_origin_scene_id', new sfValidatorPass(array('required' => false)));
  }
	public function getFields()
	{
		return array(
			'created_at'               => 'Date',
			'sf_guard_user_profile_id' => 'Number',
			'board_id'                 => 'Number',
			'repin_origin_scene_id'    => 'Number',
		);
	}
}
