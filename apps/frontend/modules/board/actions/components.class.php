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
	}

	public function executeClipStickerLogic()
	{
		$this->friended_video = false;
		$this->sticker_type = null;

		$this->reclip_id = $this->getVar('reclip_id');

		$this->current_user = $this->getVar('current_user');
		$this->social_info = $this->getVar('social_info');
		$this->clip_social_info_id = $this->getVar('clip_social_info_id');

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
					$this->sticker_type = null;
					//Существует, если оно от внутрисистемных друзей, то показывать не надо
					//$this->reclip_id = $reclip['id'];
					//$this->friended_video = $reclip['friended_video'];
				}
				else
				{
					$this->sticker_type = 'new';
					//Не существует, новое видео, надо сохранить
					$this->reclip_id = ClipSaver::saveReclip($this->clip, $this->current_user->getId(), $this->social_info)->getId();
					if($cache = $this->getContext()->getViewCacheManager())
					{
						$cache->remove('@sf_cache_partial?module=home&action=_clipList&sf_cache_key='.$this->current_user->getId().'*');
					}
				}
				//Сброс кэша для этого компонента
			}
		}
		else
		{
			$this->sticker_type = 'typical';
		}
/*
		die();

		if($this->getVar('fb_user_id'))
		{
			$this->fb_user_id = $this->getVar('fb_user_id');

			if($this->getVar('clip_key'))
			{
				$this->clip_key = $this->getVar('clip_key');
				$this->fb_desc = $this->getVar('fb_desc');
				$this->fb_created_at = $this->getVar('fb_created_at');
				$this->fb_post_id = $this->getVar('fb_post_id');

				$source = SourcePeer::retrieveByName('youtube');
				$this->source_id = $source['id'];

				$this->clip = ClipSaver::saveClip($this->clip_key, $this->source_name, $this->source_id);

				//Существует ли это видео со сценами у нас?
				$reclip = ReclipPeer::retrieveByClipIdFromFriends($this->clip->getId(), $this->current_user->getId());
				if($reclip)
				{
					//Существует, если оно от друзей, то показывать не надо
					$this->reclip_id = $reclip['id'];
					$this->friended_video = $reclip['friended_video'];
				}
				else
				{
					//Не существует, новое видео, надо сохранить
					ClipSaver::saveReclip($this->clip->getId(), $this->current_user->getId(), $this->fb_user['id'], $this->fb_post_id);
				}
			}
		}*/
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
