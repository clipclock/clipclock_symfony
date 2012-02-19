<?php

/**
 * Scene form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class SceneForm extends BaseSceneForm
{
	public function configure()
	{
		parent::setup();

		$this->setWidgets(array(
			'id'                       => new sfWidgetFormInputHidden(),
			'board_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Board', 'add_empty' => false)),
			'text'                     => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
			'board_id'                 => new sfValidatorPropelChoice(array('model' => 'Board', 'column' => 'id')),
			'text'                     => new sfValidatorString(),
		));

		$this->widgetSchema->setNameFormat('scene[%s]');

		$this->getObject()->setSfGuardUserProfileId($this->getOption('sf_guard_user_profile_id'));
		$this->getObject()->setCreatedAt($this->getOption('created_at'));
	}
}
