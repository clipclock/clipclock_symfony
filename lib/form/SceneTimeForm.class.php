<?php

/**
 * SceneTime form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class SceneTimeForm extends BaseSceneTimeForm
{
	public function configure()
	{
		unset($this['id']);
		unset($this['created_at']);
		unset($this['unique_comments_count']);

		$this->setWidget('scene_time', new sfWidgetFormInputHidden());
		$this->setWidget('clip_id', new sfWidgetFormInputHidden());

		$this->embedForm('scene', new SceneForm(null, array(
			'created_at' => $this->getOption('created_at'),
			'sf_guard_user_profile_id' => $this->getOption('sf_guard_user_profile_id'),
		)));

		$this->getObject()->setClipId($this->getOption('clip_id'));
		$this->getObject()->setCreatedAt($this->getOption('created_at'));
		//sfForm::disableCSRFProtection();
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

		foreach($forms as $form)
		{
			$form->getObject()->setSceneTimeId($this->getObject()->getId());
		}
		parent::saveEmbeddedForms($con, $forms);
	}
}
