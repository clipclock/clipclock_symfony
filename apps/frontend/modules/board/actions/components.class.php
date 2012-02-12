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
	public function executeBoardSticker()
	{
		$this->board = $this->getVar('board');

		$this->scenes = $this->board->getScenes()->getData();
		$this->scenes_images = ClipPreview::c14nArrayObjects($this->scenes, 'small');
	}

	public function executeBoardsListPreview()
	{
		$this->current_board = $this->getVar('current_board');
		$this->similiar_boards = $this->current_board->getSimilarFromUser();
	}
}
