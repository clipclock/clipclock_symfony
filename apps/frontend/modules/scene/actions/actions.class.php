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
        $this->current_user = $this->getUser();
		$this->user = $this->current_scene->getSfGuardUserProfile();
		$this->form = new SceneCommentForm();
	}

	public function executeShowSceneAjax(sfWebRequest $request)
	{
		$this->scene_id = $request->getParameter('scene_id');
		$scene = ScenePeer::retrieveByPK($this->scene_id);

		$this->forward404Unless($this->scene_id);

		$this->getContext()->getConfiguration()->loadHelpers(array('Navigation', 'Comment'));
		return $this->returnJSON(array(
			'scene_comments_list' => $this->getComponent('scene', 'sceneViewComments', array('scene_time_id' => $scene->getSceneTimeId(), 'current_user' => $this->getUser())),
			'scene_comment_form' => $this->getComponent('scene', 'sceneViewCommentForm', array('scene_time_id' => $scene->getSceneTimeId(), 'current_user' => $this->getUser())),
			'scene_description' => $this->getComponent('scene', 'sceneViewDescription', array('scene_id' => $this->scene_id)),
			'scene_people_sticker' => $this->getComponent('scene', 'peopleForSceneSticker', array('scene_id' => $this->scene_id)),
			'scene_social_buttons' => $this->getComponent('scene', 'sceneViewSocialButtons', array('scene_id' => $this->scene_id, 'user' => $scene->getSfGuardUserProfile(), 'current_user' => $this->getUser())),
			'nav_path' => buildNavigationPath($scene),
			'nav_avatar' => link_to(image_tag(ImagePreview::c14n($scene->getSfGuardUserProfileId(), 'medium', 'avatar')), array('sf_route' => 'user', 'nick' => $scene->getSfGuardUserProfile()->getNick())),
			'rating_url' => $this->generateUrl('scene_post_comment_rating')
		));
	}

	public function executePostScene(sfWebRequest $request)
	{
		$this->scene_time_form = new SceneTimeForm(null, array(
			'created_at' => time(),
			'sf_guard_user_profile_id' => $this->getUser()->getId(),
		));

		$this->scene_time_form->bind($request->getParameter($this->scene_time_form->getName()));

		$this->scene_time_form->save();

		$this->redirect($this->generateUrl('scene', array(
			'username_slug' => $this->getUser()->getNick(),
			'board_id' => $this->scene_time_form->getEmbeddedForm('scene')->getObject()->getBoardId(),
			'id' => $this->scene_time_form->getEmbeddedForm('scene')->getObject()->getId()
		)));
	}

	public function executePostComment(sfWebRequest $request)
	{
		$this->scene_comment_form = new SceneCommentForm(new SceneComment(), array(
			'sf_guard_user_profile_id' => $this->getUser()->getId(),
			'created_at' => time()
		));

		$this->scene_comment_form->bind($request->getParameter($this->scene_comment_form->getName()));

		$this->forward404Unless($this->scene_comment_form->isValid());
		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));

		$this->scene_comment_form->save();

		return $this->returnJSON(array(
			'scene_new_comment' => $this->getPartial('scene/sceneViewComment', array('comment' => $this->scene_comment_form->getObject(), 'current_user' => $this->getUser(), 'ajax' => true, 'has_voted' => true)),
		));
	}

	public function executePostCommentRating(sfWebRequest $request)
	{
		$this->forward404Unless($request->getMethod() == sfRequest::POST && $this->getUser()->getId());

		$this->getContext()->getConfiguration()->loadHelpers(array('Comment'));

		$rating = SceneCommentPeer::addRatingByIdAndUserId($request->getParameter('id'), $this->getUser()->getId(), (bool)$request->getParameter('sign'));

		return $this->returnJSON(array(
			'scene_comment_rating' => $this->getPartial('scene/sceneViewCommentRating', array('rating' => $rating)),
		));
	}

	public function returnJSON($data)
	{
		$json = json_encode($data);

		$this->getResponse()->setHttpHeader('Content-type', 'application/json');

		return $this->renderText($json);
	}

	public function executeUnrepin(sfWebRequest $request)
	{
		$origin_scene = ScenePeer::retrieveByPK($request->getParameter('scene_id'));
		$this->getContext()->getConfiguration()->loadHelpers(array('Url'));

		if(SceneRepinPeer::toggleBySceneIdAndUserIdByState($request->getParameter('scene_id'), $this->getUser()->getId(), false)
				== SceneRepinPeer::UN_PINNED)
		{
			$result = array('result' => 'success', 'location' => url_for(array(
										'sf_route' => 'scene',
										'username_slug' => $origin_scene->getSfGuardUserProfile()->getNick(),
										'board_id' => $origin_scene->getBoardId(),
										'id' => $origin_scene->getId())), 'content' => 'toggled successfully');
		}
		else
		{
			$result = array('result' => 'unsuccess', 'content' => 'something wrong');
		}

		return $this->returnJSON($result);

	}

	public function executeRepin(sfWebRequest $request)
	{
		$this->scene_form = new RepinModalForm(null);

		$this->scene_form->bind($request->getParameter($this->scene_form->getName()));

		$this->scene_form->save();

		$this->redirect($this->generateUrl('scene', array(
			'username_slug' => $this->getUser()->getNick(),
			'board_id' => $this->scene_form->getObject()->getBoardId(),
			'id' => $this->scene_form->getObject()->getId()
		)));
	}

	public function executeToggleFBLikeState(sfWebRequest $request)
	{
		if ($this->getUser()->getId() != $request->getParameter('user_id'))
			return $this->returnJSON(array('code' => 403, 'content' => 'forbidden'));

		return (SceneLikePeer::toggleBySceneIdAndUserIdByState($request->getParameter('scene_id'),
                                                               $request->getParameter('user_id'),
                                                               $request->getParameter('state'))) ?

				$this->returnJSON(array('code' => 200, 'content' => 'toggled successfully')) :
				$this->returnJSON(array('code' => 500, 'content' => 'something wrong')) ;

	}
}
