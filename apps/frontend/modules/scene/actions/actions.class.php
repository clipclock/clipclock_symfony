<?php

/**
 * scene actions.
 *
 * @package    videopin
 * @subpackage scene
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sceneActions extends sfActions
{
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
		$this->current_scene = $this->getRoute()->getObject();
		$this->form = new SceneCommentForm();
	}

	public function executeShowSceneAjax(sfWebRequest $request)
	{
		$this->scene_id = $request->getParameter('scene_id');
		$scene = ScenePeer::retrieveByPK($this->scene_id);

		$this->forward404Unless($this->scene_id);

		return $this->returnJSON(array(
			'scene_comments_list' => $this->getComponent('scene', 'sceneViewComments', array('scene_time_id' => $scene->getSceneTimeId())),
			'scene_comment_form' => $this->getComponent('scene', 'sceneViewCommentForm', array('scene_time_id' => $scene->getSceneTimeId())),
			'scene_description' => $this->getComponent('scene', 'sceneViewDescription', array('scene_id' => $this->scene_id)),
			'scene_people_sticker' => $this->getComponent('scene', 'peopleForSceneSticker', array('scene_id' => $this->scene_id)),
			'scene_social_buttons' => $this->getComponent('scene', 'sceneViewSocialButtons', array('scene_id' => $this->scene_id))
		));
	}

	public function executePostComment(sfWebRequest $request)
	{
		$this->scene_comment_form = new SceneCommentForm(new SceneComment(), array(
			'sf_guard_user_profile_id' => $this->getUser()->getId(),
			'created_at' => time()
		));

		$this->scene_comment_form->bind($request->getParameter($this->scene_comment_form->getName()));

		$this->forward404Unless($this->scene_comment_form->isValid());

		$this->scene_comment_form->save();

		return $this->returnJSON(array(
			'scene_new_comment' => $this->getPartial('scene/sceneViewComment', array('comment' => $this->scene_comment_form->getObject())),
		));
	}

	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}
}
