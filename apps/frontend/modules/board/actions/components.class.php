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
		$this->scene_id = $this->getVar('scene_id');
		$this->scene_time = $this->getVar('scene_time');
		$this->board = $this->getVar('board');

		$this->scene_image = ImagePreview::c14n($this->clip_id.$this->scene_time, 'medium');
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
		$this->reclip_id = $this->getVar('reclip_id');

		$this->scene_info = ScenePeer::retrieveFirstSceneTimeIdByClipIdBoardId($this->reclip_id, $this->getVar('current_user')->getId());
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
