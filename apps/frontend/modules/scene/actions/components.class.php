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

	public function executeModalForm()
	{
		$this->form = $this->getVar('form');
		$this->form_url = $this->getVar('form_url');
		$this->form_partial = $this->getVar('form_partial');
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

		$this->form = new SceneTimeForm(null, array('clip_id' => $this->clip_id));
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
		$this->user = $this->getUser();
        
		$counts = ScenePeer::countRepinsLikesForSceneId($this->scene_id);
		$this->repins_count = $counts['repins_count'];
		$this->likes_count = $counts['likes_count'];

        $scene = ScenePeer::retrieveByPK($this->scene_id);
        /**
         * @var $scene Scene
         */


        $scene->setNew(true);
        $scene->fromArray(array(
                                'Id' => null,
                                'CreatedAt' => null,
                                'SfGuardUserProfileId' => $this->user->getId(), //$this->user->getProfile()->getId()
                                'RepinOriginSceneId' => $this->scene_id
                          ));

		$this->form = new RepinModalForm($scene, array('sf_guard_user_profile_id' => $this->getUser()->getId()));
	}
}
