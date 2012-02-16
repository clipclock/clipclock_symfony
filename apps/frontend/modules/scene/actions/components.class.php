<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */
class sceneComponents extends sfComponents
{
	public function executePeopleForSceneSticker()
	{
		$this->scene_id = $this->getVar('scene_id');
		$this->liked_user_ids = SceneLikePeer::retrieveIdsBySceneId($this->scene_id);
		$this->repined_user_ids = SceneRepinPeer::retrieveIdsBySceneId($this->scene_id);
	}

	public function executePeopleForSceneStickerUser()
	{
		$this->user_id = $this->getVar('user_id');

		$this->user = SfGuardUserProfilePeer::retrieveByPK($this->user_id);
	}

	public function executeSceneView()
	{
		$this->scene = $this->getVar('scene');

		$this->scene_time = $this->scene->getSceneTime();
		$this->clip = ClipPeer::retrieveBySceneTimeId($this->scene->getSceneTimeId());
	}

	public function executeSceneViewEmbed()
	{
		$this->clip = $this->getVar('clip');
		$this->scene_time = $this->getVar('scene_time');
	}

	public function executeSceneViewControl()
	{
		$this->board_id = $this->getVar('board_id');
		$this->clip_id = $this->getVar('clip_id');
		$this->scene_id = $this->getVar('scene_id');

		$this->scene_times = ScenePeer::retrieveAscSceneTimeIdByClipIdBoardId($this->clip_id, $this->board_id);
	}
}
