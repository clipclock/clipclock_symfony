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
		$this->current_board = $this->getRoute()->getObject();
		$this->current_user = $this->getUser()->getProfile();

		$this->forward404Unless($this->current_board);
	}

	public function executeShowSceneAjax(sfWebRequest $request)
	{
		$this->scene_id = $request->getParameter('scene_id');

		$this->forward404Unless($this->scene_id);

		$this->getContext()->getConfiguration()->loadHelpers(array('comment'));

		$this->scene_comments_list = $this->getComponent('board', 'clipStickerSceneTimeCommentsListShort', array('scene_id' => $this->scene_id));
		$this->scene_image = $this->getComponent('board', 'clipStickerSceneTimePreview', array('scene_id' => $this->scene_id));

		return $this->returnJSON(array(
			'scene_id' => $this->scene_id,
			'scene_image' => $this->scene_image,
			'scene_comments_list' => $this->scene_comments_list,
			'scene_footer' => $this->getComponent('board', 'clipStickerFooter', array('scene_id' => $this->scene_id))
		));
	}
	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}
}
