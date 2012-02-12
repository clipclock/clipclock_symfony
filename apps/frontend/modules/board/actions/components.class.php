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
	/**
	 * @var Board
	 */
	protected $board;

	/**
	 * @var Board
	 */
	protected $current_board;

	public function executeBoardSticker()
	{
		$this->board = $this->getVar('board');

		/*
		 * TODO: rename to board_scenes
		 */
		$this->scenes = $this->board->getScenes()->getData();
		/*
		 * TODO: rename to ScenePreview
		 */
		$this->scenes_images = ClipPreview::c14nArrayObjects($this->scenes, 'small');
	}

	public function executeBoardsListPreview()
	{
		$this->current_board = $this->getVar('current_board');
		$this->similiar_boards = $this->current_board->getSimilarFromUser();
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

		$this->clip_scenes_images = ClipPreview::c14nArrayObjects($scenes, 'big');
		unset($scenes);
	}
}
