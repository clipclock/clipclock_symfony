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

		$this->scene_image = SceneTimePreview::c14n($this->scene_time->getId(), 'small');
	}

	public function executeBoardClipsList()
	{
		$this->board = $this->getVar('current_board');
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
		$this->scene_time_id = $this->getVar('scene_time_id');

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
		$this->current_scene_time_id = $this->getVar('current_scene_time_id');

		$this->comments = SceneCommentPeer::retrieveBySceneTimeId(
			$this->current_scene_time_id,
			calculateCommentListLength($this->getVar('unique_comments_count'))
		);
	}

	public function executeClipStickerFooter()
	{
		$this->current_scene_id = $this->getVar('current_scene_id');
		$this->current_scene_time_id = $this->getVar('current_scene_time_id');

		$counts = ScenePeer::countRepinsLikesForSceneId($this->current_scene_id);
		$this->repins_count = $counts['repins_count'];
		$this->likes_count = $counts['likes_count'];

		$my_counts = ScenePeer::countLikesForSceneIdByUserId($this->current_scene_id, $this->getUser()->getId());
		$this->i_repin = $my_counts['repins_count'] ? true : false;
		$this->i_like = $my_counts['likes_count'] ? true : false;

		$counts = SceneTimePeer::countCommentsForSceneTimeId($this->current_scene_time_id);
		$this->comments_count = $counts['comments_count'];
	}
}
