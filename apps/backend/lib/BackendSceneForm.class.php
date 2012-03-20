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

		$this->embedForm('scene_time', new BackendSceneTimeForm($this->getObject()->getSceneTime()));
		$this->widgetSchema['created_at'] = new sfWidgetFormJQueryDate();

		if(!$this->isNew())
		{
			$this->setOption('c14n_id', $this->getObject()->getSceneTime()->getReclip()->getClipId().$this->getObject()->getSceneTime()->getSceneTime());

			$c = new Criteria();
			$c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $this->getObject()->getSfGuardUserProfileId());
			$this->setWidget('board_id', new sfWidgetFormPropelChoice(array('model' => 'Board', 'add_empty' => false, 'criteria' => $c)));
			$this->setValidator('board_id', new sfValidatorPropelChoice(array('model' => 'Board', 'column' => 'id', 'criteria' => $c)));
		}
		unset($this['scene_time_id']);
		unset($this['scene_like_list']);
		unset($this['scene_repin_list']);
		unset($this['scene_repost_list']);
	}

	public function bind(array $taintedValues = null, array $taintedFiles = null)
	{
		unset($this['sf_guard_user_profile_id']);
		unset($this['repin_origin_scene_id']);

		$this->prev_scene_time = $this->getObject()->getSceneTime()->getSceneTime();
		$this->prev_clip_url = $this->getObject()->getSceneTime()->getReclip()->getClip()->getUrl();
		parent::bind($taintedValues, $taintedFiles);
	}

	public function save($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(ScenePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			parent::save($con);
			if($this->getObject()->getSceneTime()->getSceneTime() != $this->prev_scene_time ||
					$this->getObject()->getSceneTime()->getReclip()->getClip()->getUrl() != $this->prev_clip_url)
			{
				$c14n_id = $this->getObject()->getSceneTime()->getReclip()->getClipId().$this->getObject()->getSceneTime()->getSceneTime();
				ImagePreview::deleteAllImages($c14n_id);

				$publish_helper = new AMQPPublisher();
				$publish_helper->jobScene($c14n_id, $this->getObject()->getSceneTime()->getReclip()->getClip()->getUrl(), $this->getObject()->getSceneTime()->getSceneTime());
			}
			$con->commit();
			return $this->getObject();
		}
		catch(Exception $e)
		{
			$con->rollBack();
			throw $e;
		}

		return $this->getObject();
	}
}
