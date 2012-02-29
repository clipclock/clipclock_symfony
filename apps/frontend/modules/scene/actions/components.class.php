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
		$this->scene = ScenePeer::retrieveByPK($this->getVar('scene_id'));
		$this->liked_user_ids = SceneLikePeer::retrieveIdsBySceneId($this->scene->getId());
		$this->repined_user_ids = SceneRepinPeer::retrieveIdsBySceneId($this->scene->getId());
	}

	public function executePeopleForSceneStickerUser()
	{
		$this->user_id = $this->getVar('user_id');

		$this->user = SfGuardUserProfilePeer::retrieveByPK($this->user_id);
	}

    public function executeFacebookLikeButton($render = array())
    {

    }

	public function executeSceneView()
	{
		$this->scene = $this->getVar('scene');

		$this->scene_time = $this->scene->getSceneTime();
		$this->clip = ClipPeer::retrieveBySceneTimeId($this->scene->getSceneTimeId());
	}

	public function executeSceneViewEmbed()
	{
		$this->scene_time_id = $this->getVar('scene_time_id');

		$scene_time = SceneTimePeer::retrieveByPK($this->scene_time_id);
		$this->scene_time = $scene_time->getSceneTime();

		$this->clip = ClipPeer::retrieveBySceneTimeId($this->scene_time_id);
	}

	public function executeSceneViewControl()
	{
		$this->board_id = $this->getVar('board_id');
		$this->clip_id = $this->getVar('clip_id');
		$this->scene_id = $this->getVar('scene_id');

		$this->scene_times = ScenePeer::retrieveAscSceneTimeIdByClipIdBoardId($this->clip_id, $this->board_id);

		$this->form = new SceneTimeForm(null, array('clip_id' => $this->clip_id, 'sf_guard_user_profile_id' => $this->getUser()->getId()));
	}

	public function executeSceneViewDescription()
	{
        $this->scene = ScenePeer::retrieveByPK($this->scene_id);
	}

	public function executeSceneViewCommentForm()
	{
		$scene_comment = new SceneComment();
		$scene_comment->setSceneTimeId($this->getVar('scene_time_id'));
		$scene_comment->setSfGuardUserProfileId($this->getUser()->getId());

		$this->form = new SceneCommentForm($scene_comment);
	}

	public function executeSceneViewComments()
	{
		$this->comments = SceneCommentPeer::retrieveFullBySceneTimeId(
			$this->getVar('scene_time_id')
		);
	}

	public function executeSceneViewSocialButtons()
	{
		$this->scene_id = $this->getVar('scene_id');
		$this->scene = ScenePeer::retrieveByPK($this->scene_id);
		$this->origin_scene_id = ($this->scene->getRepinOriginSceneId()) ? $this->scene->getRepinOriginSceneId() : $this->scene_id;
		$this->current_user = $this->getVar('current_user');
        
		$counts = ScenePeer::countRepinsLikesForSceneId($this->origin_scene_id);
		$this->repins_count = $counts['repins_count'];
		$this->likes_count = $counts['likes_count'];
		$new_scene = clone($this->scene);

        $new_scene->setNew(true);
        $new_scene->fromArray(array(
                                'Id' => null,
                                'CreatedAt' => time(),
                                'SfGuardUserProfileId' => $this->current_user->getId(),
                                'RepinOriginSceneId' => ($new_scene->getRepinOriginSceneId()) ? $new_scene->getRepinOriginSceneId() : $this->scene_id
                          ));

		$this->repin_form = new RepinModalForm($new_scene, array('sf_guard_user_profile_id' => $this->current_user->getId()));
	}
}
