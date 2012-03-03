<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lmaxim
 * Date: 2/20/12
 * Time: 12:52 PM
 * To change this template use File | Settings | File Templates.
 */

class RepinModalForm extends BaseSceneForm
{

	public function configure()
	{
		unset($this['scene_repost_list']);
		unset($this['scene_repin_list']);

		$c = new Criteria();

		$c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $this->getOption('sf_guard_user_profile_id'));
		$c->addJoin(BoardPeer::ID, ScenePeer::BOARD_ID, Criteria::INNER_JOIN);
		$c->addDescendingOrderByColumn(ScenePeer::CREATED_AT);

		$fields = $this->widgetSchema->getFields();

		$this->setWidgets(array());

		foreach(array_keys($fields) as $field_name)
		{
			if(!in_array($field_name, array('scene_repin_list', 'scene_like_list')))
			{
				$this->setWidget($field_name, new sfWidgetFormInputHidden());
			}
		}

		$this->setWidget('board_id', new sfWidgetFormPropelChoice(array('model' => 'Board', 'add_empty' => false, 'criteria' => $c)));

		$new_board = new NewBoardForm(null, array(
			'sf_guard_user_profile_id' => $this->getOption('sf_guard_user_profile_id'),
		));

		$this->embedForm('board', $new_board);

		$this->widgetSchema->setNameFormat('repin_modal_form[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);


	}

	public function bind(array $taintedValues = null, array $taintedFiles = null)
	{
		parent::bind($taintedValues, $taintedFiles);
	}

	public function save($con = null)
	{
		if(null === $con)
		{
			$con = $this->getConnection();
		}

		try
		{
			$con->beginTransaction();

			parent::save($con);

			SceneRepinPeer::toggleBySceneIdAndUserIdByState($this->getObject()->getRepinOriginSceneId(),
				$this->getObject()->getSfGuardUserProfileId(),
				true);

			$con->commit();

			return $this->getObject();
		}
		catch(Exception $e)
		{
			$con->rollBack();

			throw $e;
		}

		return null;
	}

	public function saveEmbeddedForms($con = null, $forms = null)
	{
		if(null === $con)
		{
			$con = $this->getConnection();
		}

		if(null === $forms)
		{
			$forms = $this->embeddedForms;
		}

		foreach($forms as $key => $form)
		{
			$values = $this->getValues();
			$this->getObject()->setSceneTimeId(
				SceneTimePeer::repinSceneTimeBySceneTimeUserId($this->getObject()->getSceneTime(), $this->getObject()->getSfGuardUserProfileId())
			);
			if(!empty($values[$key]['name']))
			{
				$this->getObject()->setBoardId(
					BoardPeer::createOrReturnId($values[$key]['name'], $this->getObject()->getSfGuardUserProfileId())
				);
			}
			$this->getObject()->save($con);
			unset($forms[$key]);
		}

		parent::saveEmbeddedForms($con, $forms);
	}

}
