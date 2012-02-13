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
		$this->current_board = $this->getVar('current_board');
		$this->clips_ids = ScenePeer::retrieveClipsIdsByBoard($this->current_board);
	}

	public function executeClipSticker()
	{
		$this->clip_id = $this->getVar('clip_id');

		$scenes = ScenePeer::retrieveByClipId($this->clip_id);
		$this->clip_scenes = array_slice($scenes, 1, null, true);
		$this->clip_main_scene = current(array_slice($scenes, 0, 1, true));

		$this->clip_scenes_images = SceneTimePreview::c14nArrayObjects($scenes, 'big');
		unset($scenes);
	}
}
