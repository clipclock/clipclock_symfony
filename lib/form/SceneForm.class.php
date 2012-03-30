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
			'name'                     => new sfWidgetFormInputText(),
			'text'                     => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
			'board_id'                 => new sfValidatorPropelChoice(array('model' => 'Board', 'column' => 'id')),
			'name'                     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
			'text'                     => new sfValidatorString(),
		));


		$c = new Criteria();
		$c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $this->getOption('sf_guard_user_profile_id'));
		$c->addJoin(BoardPeer::ID, ScenePeer::BOARD_ID, Criteria::INNER_JOIN);
		$c->addDescendingOrderByColumn(ScenePeer::CREATED_AT);
		$this->setWidget('board_id', new sfWidgetFormPropelChoice(array('model' => 'Board', 'add_empty' => false, 'criteria' => $c)));

		if($this->getOption('no_boards'))
		{
			unset($this['board_id']);
		}

		$this->widgetSchema->setNameFormat('scene[%s]');

		$this->getObject()->setSfGuardUserProfileId($this->getOption('sf_guard_user_profile_id'));
		$this->getObject()->setCreatedAt($this->getOption('created_at'));
		$this->setDefault('text', 'Pause the video on the moment you want to clip, enter the description text and hit the "create clip" button.');
	}
}
