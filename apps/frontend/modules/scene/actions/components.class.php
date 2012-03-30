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
	protected function preparePeople($modal = false)
	{
		$this->scene = ScenePeer::retrieveByPK($this->getVar('scene_id'));
		$this->liked_user_ids = SceneLikePeer::retrieveIdsBySceneId($this->scene->getId(), $modal ? 10 : null);
		$this->repined_user_ids = SceneRepinPeer::retrieveIdsBySceneId($this->scene->getId(), $modal ? 8 : null, true);
	}

	public function executePeopleForSceneSticker()
	{
		$this->preparePeople();
	}

	public function executePeopleForSceneModal()
	{
		$this->preparePeople(true);
		$this->repins_count = count($this->repined_user_ids);
	}

	protected function prepareUserForPeopleSticker($modal = false)
	{
		$this->user_id = $this->getVar('user_id');
		$this->modal = $this->getVar('modal');

		$this->user = SfGuardUserProfilePeer::retrieveByPK($this->user_id);
	}

	public function executePeopleForSceneStickerUser()
	{
		$this->prepareUserForPeopleSticker();
	}

	public function executePeopleForSceneStickerUserReclip()
	{
		//$this->board_name = $this->getVar('board_name');
		$this->prepareUserForPeopleSticker();
	}

    public function executeFacebookLikeButton($render = array())
    {

    }

	public function executeSceneView()
	{
		$this->scene = $this->getVar('scene');

		$this->scene_time = $this->scene->getSceneTime();
		$this->reclip = ReclipPeer::retrieveBySceneTimeId($this->scene->getSceneTimeId());

		$this->control_scene_times = ScenePeer::retrieveAscSceneTimeIdByClipIdBoardId($this->reclip->getId(), $this->scene->getBoardId());

		$fb = sfConfig::get('app_melody_facebook');
		$this->response->addMeta('fb:app_id', $fb['key']);
		$this->response->addMeta('og:locale', 'en_US');

		$this->response->addMeta('og:url', $this->generateUrl('scene', array('username_slug' => $this->user, 'board_id' => $this->scene->getBoardId(), 'id' => $this->scene->getId()), true));
		$this->response->addMeta('og:title', $this->scene->getText());
		$this->response->addMeta('og:image', $this->generateUrl('homepage', array(), true).substr(ImagePreview::c14n($this->reclip->getClip()->getId().$this->scene_time->getSceneTime(), 'big'), 1));
		$this->response->addMeta('og:description', $this->reclip->getClip()->getName().' at '.$this->scene_time);
		$this->response->addMeta('og:site_name', $this->getResponse()->getTitle());

		//$this->response->addMeta('og:type', 'video.other');
		$this->response->addMeta('og:type', 'clipclock:clip');
		$this->response->addMeta('og:video', 'http://www.youtube.com/v/'.$this->reclip->getClip()->getUrl().'?enablejsapi=1&playerapiid=ytplayer&start='.$this->scene_time->getSceneTime().'&autoplay=1&version=3&feature=player_embedded&fs=1&rel=0&showsearch=0&showinfo=0');
		$this->response->addMeta('og:video:type', 'application/x-shockwave-flash');
		$this->response->addMeta('og:video:width', '398');
		$this->response->addMeta('og:video:height', '224');
	}

	public function executeSceneViewEmbed()
	{
	}

	public function executeSceneViewControl()
	{
		$this->scene_times = $this->getVar('control_scene_times');
		$this->reclip_id = $this->getVar('reclip_id');

		$this->modal = $this->getVar('modal');
		$this->tab_limit = $this->modal ? 5 : 7;

		$this->form = new SceneTimeForm(null, array('reclip_id' => $this->reclip_id, 'sf_guard_user_profile_id' => $this->getUser()->getId()));
	}

	public function executeSceneViewDescription()
	{
		$this->scene_id = $this->getVar('scene_id');
		$this->scene_times = $this->getVar('control_scene_times');
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

		$this->my_votes = SceneCommentRatingVotesPeer::retrieveForSceneTimeId($this->getVar('scene_time_id'), $this->getVar('current_user')->getId());
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
		$fb = sfConfig::get('app_melody_facebook');
		$this->fb_app_id = $fb['key'];
	}
}
