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
		$this->user = $this->getVar('user');
		$this->linked_boards_ids = BoardPeer::retrieveIdsLinkedBoardsByUserId($this->current_board->getId(), $this->user->getId());
	}

	public function executeBoardSticker()
	{
		$this->board_id = $this->getVar('board_id');
		$this->user = $this->getVar('user');
		$this->board = BoardPeer::retrieveByPK($this->board_id);

		$this->clips_ids = SceneTimePeer::retrieveClipsIdsByBoard($this->board_id);
	}

	public function executeBoardStickerSceneTimePreview()
	{
		$this->clip_id = $this->getVar('clip_id');
		$this->board_id = $this->getVar('board_id');
		$this->scene = ScenePeer::retrieveBestByClipId($this->clip_id, $this->board_id);

		$this->scene_image = ImagePreview::c14n($this->scene->getSceneTimeId(), 'medium');
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

	public function executeClipSticker()
	{
		$this->clip_id = $this->getVar('clip_id');
		$this->board_id = $this->getVar('board_id');
		$this->scene = ScenePeer::retrieveFirstSceneTimeIdByClipIdBoardId($this->clip_id, $this->board_id);
	}

	public function executeClipStickerSceneTimePreview()
	{
		$this->scene = $this->getVar('scene');
		$this->scene_image = ImagePreview::c14n($this->scene->getSceneTimeId(), 'big');
	}

	public function executeClipStickerControl()
	{
		$this->clip_id = $this->getVar('clip_id');
		$this->board_id = $this->getVar('board_id');

		$this->scene_times = ScenePeer::retrieveAscSceneTimeIdByClipIdBoardId($this->clip_id, $this->board_id);
	}

	public function executeClipStickerSceneTimeCommentsListShort()
	{
		$this->scene = $this->getVar('scene');
		$this->unique_comments_count = $this->scene->getSceneTime()->getUniqueCommentsCount();

		$this->comments = SceneCommentPeer::retrieveShortBySceneId(
			$this->scene->getId(),
			calculateCommentListLength($this->unique_comments_count)
		);
	}

	public function executeClipStickerFooter()
	{
		$this->scene = $this->getVar('scene');
		$this->scene_time_id = $this->scene->getSceneTimeId();

		$counts = ScenePeer::countRepinsLikesForSceneId($this->scene->getId());
		$this->repins_count = $counts['repins_count'];
		$this->likes_count = $counts['likes_count'];

		$my_counts = ScenePeer::countLikesForSceneIdByUserId($this->scene->getId(), $this->getUser()->getId());
		$this->i_repin = $my_counts['repins_count'] ? true : false;
		$this->i_like = $my_counts['likes_count'] ? true : false;

		$counts = SceneTimePeer::countCommentsForSceneTimeId($this->scene_time_id);
		$this->comments_count = $counts['comments_count'];
	}
}
