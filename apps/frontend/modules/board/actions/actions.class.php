<?php

/**
 * board actions.
 *
 * @package    videopin
 * @subpackage board
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class boardActions extends sfActions
{
	/**
	 * @var Board
	 */
	protected $board;
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward('default', 'module');
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->board = $this->getRoute()->getObject();
		$this->user = $this->board->getSfGuardUserProfile();

		$this->forward404Unless($this->board);

		//Component
		$this->scenes = $this->board->getScenes()->getData();
		$this->scenes_images = ClipPreview::c14nArrayObjects($this->scenes);
	}
}
