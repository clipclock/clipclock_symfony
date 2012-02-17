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
	public function executeBoardsLinked()
	{
		$this->current_board = $this->getVar('current_board');
		$this->linked_boards_ids = $this->current_board->getLinkedBoardsIds();
	}

	public function executeBoardSticker()
	{
		$this->board_id = $this->getVar('board_id');
		$this->board = BoardPeer::retrieveByPK($this->board_id);

		$this->clips_ids = $this->board->getClipsPreviewsIds();
	}

	public function executeBoardStickerSceneTimePreview()
	{
		$this->clip_id = $this->getVar('clip_id');
		$this->board_id = $this->getVar('board_id');
		$this->scene_time = SceneTimePeer::retrieveBestByClipId($this->clip_id, $this->board_id);
		$this->scene = ScenePeer::retrieveByBoardIdSceneTimeId($this->scene_time->getId(), $this->board_id);

		$this->scene_image = SceneTimePreview::c14n($this->scene_time->getId(), 'small');
	}

	public function executeBoardClipsList()
	{
		$this->board = $this->getVar('current_board');
		$this->user = $this->getVar('user');
		$this->clips_ids = SceneTimePeer::retrieveClipsIdsForListByBoardId($this->board->getId());
		$this->getContext()->getConfiguration()->loadHelpers(array('comment'));
	}

	public function executeClipSticker()
	{
		$this->clip_id = $this->getVar('clip_id');
		$this->board_id = $this->getVar('board_id');
		$this->current_scene_id = $this->getVar('current_scene_id');

		$this->current_scene_id = null;
		if($this->current_scene_id)
		{
			$this->current_scene_id = ScenePeer::retrieveFirstSceneTimeIdById($this->current_scene_id);
		}

		if(!$this->current_scene_id)
		{
			$this->current_scene_id = ScenePeer::retrieveFirstSceneTimeIdByClipIdBoardId($this->clip_id, $this->board_id);
		}
	}

	public function executeClipStickerSceneTimePreview()
	{
		$this->scene_id = $this->getVar('scene_id');

		$this->scene = ScenePeer::retrieveByPK($this->getVar('scene_id'));

		$this->scene_image = SceneTimePreview::c14n($this->scene_time_id, 'big');
	}

	public function executeClipStickerControl()
	{
		$this->clip_id = $this->getVar('clip_id');
		$this->board_id = $this->getVar('board_id');

		$this->scene_times = ScenePeer::retrieveAscSceneTimeIdByClipIdBoardId($this->clip_id, $this->board_id);
	}

	public function executeClipStickerSceneTimeCommentsListShort()
	{
		$this->scene_id = $this->getVar('scene_id');
		if($this->getVar('unique_comments_count'))
		{
			$this->unique_comments_count = $this->getVar('unique_comments_count');
		}
		else
		{
			$unique_comments_count = ScenePeer::countUniqueCommentsBySceneId($this->scene_id);
			$this->unique_comments_count = $unique_comments_count['unique_comments_count'];
		}

		$this->scene = ScenePeer::retrieveByPK($this->getVar('scene_id'));

		$this->comments = SceneCommentPeer::retrieveShortBySceneId(
			$this->scene_id,
			calculateCommentListLength($this->unique_comments_count)
		);
	}

	public function executeClipStickerFooter()
	{
		$this->scene_id = $this->getVar('scene_id');
		$this->scene_time_id = $this->getVar('scene_time_id');

		$counts = ScenePeer::countRepinsLikesForSceneId($this->scene_id);
		$this->repins_count = $counts['repins_count'];
		$this->likes_count = $counts['likes_count'];

		$my_counts = ScenePeer::countLikesForSceneIdByUserId($this->scene_id, $this->getUser()->getId());
		$this->i_repin = $my_counts['repins_count'] ? true : false;
		$this->i_like = $my_counts['likes_count'] ? true : false;

		$counts = SceneTimePeer::countCommentsForSceneTimeId($this->scene_time_id);
		$this->comments_count = $counts['comments_count'];
	}
}
