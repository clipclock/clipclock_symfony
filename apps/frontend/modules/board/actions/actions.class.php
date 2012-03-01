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
		$this->user = $this->current_board->getSfGuardUserProfile();
		$this->current_user = $this->getUser();

		$this->forward404Unless($this->current_board);

		$this->pager = new sfPropelPager('SceneTime', 30);
		$this->pager->setCriteria(SceneTimePeer::retrieveClipsIdsForListByBoardId($this->current_board->getId()));
		$this->pager->setPeerMethod('doSelectForPager');
		$this->pager->setPage($request->getParameter('page', 1));

		if($request->isXmlHttpRequest())
		{
			return $this->returnJSON($this->getComponent('board', 'boardClipsList', array('current_board' => $this->current_board, 'pager' => $this->pager, 'current_user' => $this->current_user))
			);
		}
	}

	public function executeShowSceneAjax(sfWebRequest $request)
	{
		$scene_id = $request->getParameter('scene_id');
		$this->scene = ScenePeer::retrieveByPK($scene_id);

		$this->forward404Unless($scene_id);

		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));

		return $this->returnJSON(array(
			'scene_id' => $this->scene->getId(),
			'scene_image' => $this->getComponent('board', 'clipStickerSceneTimePreview', array('scene' => $this->scene, 'reclip_id' => $this->scene->getSceneTime()->getReclipId())),
			'scene_comments_list' => $this->getComponent('board', 'clipStickerSceneTimeCommentsListShort', array('scene' => $this->scene)),
			'scene_footer' => $this->getComponent('board', 'clipStickerFooter', array('scene' => $this->scene))
		));
	}

	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}
}
