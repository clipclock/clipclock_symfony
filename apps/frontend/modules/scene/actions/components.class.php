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
		$this->liked_user_ids = SceneLikePeer::retrieveIdsBySceneId($this->scene_id());
		$this->repined_user_ids = SceneRepinPeer::retrieveIdsBySceneId($this->scene_id());
	}

	public function executePeopleForSceneStickerUser()
	{

	}
}
