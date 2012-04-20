<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */
class boardComponents extends sfComponents
{
	public function executeCategoryPanel()
	{
		$this->user_id = $this->getVar('user_id');
		$this->board_id = $this->getVar('board_id');

		$this->category_form = false;
		if(sfConfig::get('app_boards_voting', 'false'))
		{
			$this->category_form = $this->user_id && BoardRefsUserVotesQuery::create()->filterBySfGuardUserProfileId($this->user_id)->findOneByBoardId($this->board_id)
				? false : new FrontendBoardRefsCategoryForm(new BoardRefsCategory(), array('board_id' => $this->board_id));
		}
	}

	public function executeBoardsLinked()
	{
		if($this->getVar('current_board'))
		{
			$this->current_board = $this->getVar('current_board');
			$current_board_id = $this->current_board->getId();
		}
		else
		{
			$current_board_id = null;
		}
		$this->user = $this->getVar('user');
		$this->linked_boards_ids = BoardPeer::retrieveIdsLinkedBoardsByUserId($this->user->getId(), $current_board_id);
	}

	protected function prepareBoardSticker($modal = false)
	{
		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));
		$this->board_id = $this->getVar('board_id');
		$this->user = $this->getVar('user');
		$this->board = BoardPeer::retrieveByPK($this->board_id);

		if(!$modal)
		{
			$this->clips_count = SceneTimePeer::retrieveClipsCount($this->board_id);
			$limit = calculateBoardStickerLength($this->clips_count['count']);
		}
		else
		{
			$limit = 9;
		}

		$this->clips_ids = SceneTimePeer::retrieveClipsIdsByBoard($this->board_id, $limit);
	}

	public function executeBoardSticker()
	{
		$this->prepareBoardSticker();
	}

	public function executeBoardStickerModal()
	{
		$this->prepareBoardSticker(true);
	}

	public function executeBoardStickerSceneTimePreview()
	{
		$this->clip_id = $this->getVar('clip_id');
		$this->last = $this->getVar('last');
		$this->board = $this->getVar('board');

		$scene_info = ScenePeer::retrieveBestByClipId($this->clip_id, $this->board->getId());
		$this->scene_id = $scene_info['id'];

		$this->scene_image = ImagePreview::c14n($this->clip_id.$scene_info['scene_time'], 'medium');
	}

	public function executeBoardClipsList()
	{
		$this->board = $this->getVar('current_board');
		$this->pager = $this->getVar('pager');
		$this->user = $this->getVar('user');
		$this->pager->init();
		$this->clips_ids = $this->pager->getResults();
		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));
	}

	public function executeClipStickerFromFb()
	{
		$this->reclip_id = $this->getVar('reclip_id');
		$this->reclip = ReclipQuery::create()->joinClip()->findOneById($this->reclip_id);

		$this->texts = array(
			'What is your favorite moment in this video?',
			'Could you now highlight the best moment?',
			'Where is the key point of the video?',
			'Get the meat out of the video! ))',
			'Hinge the stream at the right second!',
			'Mark and feedback the key playback time!',
			'Show the core point you see in this story.',
			'What you believe is the main episode here?',
			'Can you highlight the most interesting moment?',
			'Set the right moment for best watching this video.'
		);
	}

	public function executeClipStickerTop()
	{
		$reclip_id = $this->getVar('reclip_id');
		$clip_social_info = ClipSocialInfoPeer::retrieveByReclipId($reclip_id);
		if($clip_social_info)
		{
			$this->created_at = $clip_social_info->getCreatedAt();
			$this->user_link = 'http://facebook.com/'.$clip_social_info->getExtUser()->getExtId();
			$this->user_image = 'http://graph.facebook.com/'.$clip_social_info->getExtUser()->getExtId().'/picture?type=small';
			$this->user_nick = $clip_social_info->getExtUser()->getNick();
			$this->provider_name = ucfirst($clip_social_info->getExtUser()->getProvider()->getName());
		}
		else
		{
			$reclip = ReclipQuery::create()->findOneById($reclip_id);
			$this->created_at = $reclip->getCreatedAt();
			$this->user_link = $this->generateUrl('user', array('nick' => $reclip->getSfGuardUserProfile()->getNick()));
			$this->user_image = ImagePreview::c14n($reclip->getSfGuardUserProfileId(), 'small', 'avatar') ;
			$this->user_nick = $reclip->getSfGuardUserProfile()->getFullName();
			$this->provider_name = 'ClipClock';
		}
	}

	public function executeClipStickerLogic()
	{
		$this->friended_video = false;
		$this->sticker_type = null;

		$this->reclip_id = $this->getVar('reclip_id');

		$this->current_user = $this->getVar('current_user');
		$this->social_info = $this->getVar('social_info');

		$this->clip_social_info_id = null;
		if($this->reclip_id)
		{
			$this->clip_social_info_id = ReclipQuery::create()->findOneById($this->reclip_id)->getClip()->getClipSocialInfoId();
		}

		if($this->social_info || $this->clip_social_info_id)
		{//Неразмеченное видео
			if($this->reclip_id && $this->clip_social_info_id)//Из базы
			{
				$this->sticker_type = 'new';
				if(ScenePeer::retrieveFirstSceneTimeIdByClipIdBoardId($this->reclip_id, $this->current_user->getId()))
				{
					$this->sticker_type = 'typical';
				}
			}
			else//Из FB
			{
				$this->clip_url = $this->social_info['clip_url'];
				$this->source = $this->social_info['source'];
				$this->clip = ClipSaver::saveClip($this->clip_url, $this->source, $this->social_info);

				//Существует ли это видео со сценами у нас?
				$reclip = ReclipPeer::retrieveByClipIdFromFriends($this->clip->getId(), $this->current_user->getId());
				if($reclip && $reclip['friended_video'])
				{
					//Существует, если оно от внутрисистемных друзей, то показывать не надо
					$this->sticker_type = null;
				}
				elseif(!$reclip)
				{
					$this->sticker_type = 'new';
					//Не существует, новое видео, надо сохранить
					$this->reclip_id = ClipSaver::saveReclip($this->clip, $this->current_user->getId(), $this->social_info)->getId();
					if($cache = $this->getContext()->getViewCacheManager())
					{
						$cache->remove('@sf_cache_partial?module=home&action=_clipList&sf_cache_key='.$this->current_user->getId().'*');
						$cache->remove('@sf_cache_partial?module=board&action=_clipStickerLogic&sf_cache_key=*');
						$cache->remove('@sf_cache_partial?module=board&action=_clipStickerLogic&sf_cache_key=*');
					}
				}
				//Сброс кэша для этого компонента
			}
		}
		else
		{
			$this->sticker_type = 'typical';
		}
	}

	public function executeClipSticker()
	{
		$this->reclip_id = $this->getVar('reclip_id');
		$filter_user_id = $this->getVar('filter_user_id');
		$filter_scene_id = $this->getVar('filter_scene_id');

		$this->scene_info = ScenePeer::retrieveFirstSceneTimeIdByClipIdBoardId($this->reclip_id, $this->getVar('current_user')->getId(), $filter_user_id, $filter_scene_id);
		$this->board = BoardPeer::retrieveJoinSfGuardById($this->scene_info['board_id']);
	}

	public function executeClipStickerSceneTimePreview()
	{
		$this->scene_info = $this->getVar('scene_info');
		//$clip_id = ReclipPeer::retrieveClipIdById($this->getVar('reclip_id'));

		$this->scene_image = ImagePreview::c14n($this->scene_info['clip_id'].$this->scene_info['scene_time'], 'big');
	}

	public function executeClipStickerControl()
	{
		$this->reclip_id = $this->getVar('reclip_id');
		$this->board_id = $this->getVar('board_id');

		$this->scene_times = ScenePeer::retrieveAscSceneTimeIdByClipIdBoardId($this->reclip_id, $this->board_id);
	}

	public function executeClipStickerSceneTimeCommentsListShort()
	{
		$this->scene_info = $this->getVar('scene_info');
		$this->unique_comments_count = $this->scene_info['unique_comments_count'];
		$this->user = $this->getVar('user');
		if($this->user->getId())
		{
			$scene_comment = new SceneComment();
			$scene_comment->setSceneTimeId($this->scene_info['scene_time_id']);
			$scene_comment->setSfGuardUserProfileId($this->user->getId());

			$this->form = new SceneCommentForm($scene_comment);
		}

		$this->comments = SceneCommentPeer::retrieveShortBySceneId(
			$this->scene_info['scene_time_id'],
			calculateCommentListLength($this->unique_comments_count)
		);
	}

	public function executeClipStickerFooter()
	{
		$this->scene_info = $this->getVar('scene_info');
		$this->scene_time_id = $this->scene_info['scene_time_id'];

		$counts = ScenePeer::countRepinsLikesForSceneId($this->scene_info['scene_id']);
		$this->repins_count = $counts['repins_count'];
		$this->likes_count = $counts['likes_count'];

		/*$my_counts = ScenePeer::countLikesForSceneIdByUserId($this->scene_info['scene_id'], $this->getUser()->getId());
		$this->i_repin = $my_counts['repins_count'] ? true : false;
		$this->i_like = $my_counts['likes_count'] ? true : false;
*/
		$counts = SceneTimePeer::countCommentsForSceneTimeId($this->scene_info['scene_time_id']);
		$this->comments_count = $counts['comments_count'];
	}
}
