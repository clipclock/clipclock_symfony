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
		parent::setup();

		$this->setWidgets(array(
			'id'                       => new sfWidgetFormInputHidden(),
			'reply_to_comment_id'      => new sfWidgetFormInputHidden(),
			'scene_time_id'            => new sfWidgetFormInputHidden(),
			'text'                     => new sfWidgetFormTextarea(),
		));

		$this->setValidators(array(
			'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
			'reply_to_comment_id'      => new sfValidatorPropelChoice(array('model' => 'SceneComment', 'column' => 'id', 'required' => false)),
			'scene_time_id'            => new sfValidatorPropelChoice(array('model' => 'SceneTime', 'column' => 'id')),
			'text'                     => new sfValidatorString(),
		));

		$this->getObject()->setSfGuardUserProfileId($this->getOption('sf_guard_user_profile_id'));
		$this->getObject()->setCreatedAt($this->getOption('created_at'));

		$this->widgetSchema->setNameFormat('scene_comment[%s]');
	}
}
