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

	protected function readFeed($facebook, $provider_name, $depth, $per_page = 50)
	{
		$html_result = array();

		try
		{
			$offset = $per_page * $depth;
			$feed_result = $facebook->api('me/home?limit='.$per_page.'&offset='.$offset.'&fields=type,from,source,link,created_time,description');
		}
		catch(Exception $e)
		{
			$feed_result['data'] = array();
		}

		foreach($feed_result['data'] as $feed_item)
		{
			if($feed_item['type'] == 'video' && $feed_item['link'])
			{
				preg_match('/http\:\/\/(www.)?youtube\.com*/i', $feed_item['source'], $youtube_matches);
				if($youtube_matches)
				{
					preg_match('/http\:\/\/(www.)?clipclock\.com*/i', $feed_item['link'], $clipclock_matches);
					if(!$clipclock_matches)
					{
						preg_match('/v=([A-z\-0-9]+)/i', $feed_item['link'], $clip_key_matches);
						preg_match('/\.be\/([A-z\-0-9]+)/i', $feed_item['link'], $alter_clip_key_matches);
						if($clip_key_matches || $alter_clip_key_matches)
						{
							if(!$clip_key_matches)
							{
								$clip_url = $alter_clip_key_matches[1];
							}
							else
							{
								$clip_url = $clip_key_matches[1];
							}
							$html_result[] = $this->getComponent('board', 'clipStickerLogic', array('current_user' => $this->getUser(),
								'social_info' => array(
									'clip_url' => $clip_url,
									'created_at' => $feed_item['created_time'],
									'ext_user_id' => $feed_item['from']['id'],
									'ext_user_nick' => $feed_item['from']['name'],
									'provider' => $provider_name,
									'source' => 'youtube',
									'post_id' => str_replace($feed_item['from']['id'].'_', '', $feed_item['id']),
									'description' => isset($feed_item['description']) ? $feed_item['description'] : '',
								),
								'sf_cache_key' => $clip_url.$this->getUser()->getId()));
						}
					}
				}
			}
		}

		if(!count($html_result))
		{
			$html_result[] = '<!--1-->';
		}

		return $html_result;
	}

	public function executeShowFbSceneAjax(sfWebRequest $request)
	{
		$this->setLayout(false);
		$this->setTemplate(false);
		sfConfig::set('sf_web_debug', false);

		$config = sfConfig::get('app_melody_facebook');
		$facebook = new Facebook(array(
			'appId'  => $config['key'],
			'secret' => $config['secret'],
		));

		$max_feed_update_depth = sfConfig::get('app_feed_update_max_depth');
		$feed_update_interval = sfConfig::get('app_feed_update_interval');

		$feed_result = array();
		$html_result = array();

		$last_feed_update_at = $this->getUser()->getProfile()->getLastFeedUpdateAt();
		$last_feed_update_depth = $this->getUser()->getProfile()->getLastFeedUpdateDepth();

		if(strtotime($last_feed_update_at) + $feed_update_interval < time())
		{
			$html_result = $this->readFeed($facebook, 'facebook', $last_feed_update_depth, sfConfig::get('app_feed_update_per_page'));

			$this->getUser()->getProfile()->setLastFeedUpdateDepth(++$last_feed_update_depth);

			if($last_feed_update_depth >= $max_feed_update_depth)
			{
				$this->getUser()->getProfile()->setLastFeedUpdateAt(time());
				$this->getUser()->getProfile()->setLastFeedUpdateDepth(0);
			}

			$this->getUser()->getProfile()->save();
		}

		return $this->returnJSON($html_result);
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
		$this->control_scene_times = ScenePeer::retrieveAscSceneTimeIdByClipIdBoardId($scene->getSceneTime()->getReclipId(), $scene->getBoardId());

		/**
		 * Это жесть. Надо придумать как сделать нормально.
		 */
		$return_array = array(
			'scene_comments_list' => $this->getComponent('scene', 'sceneViewComments', array('scene_time_id' => $scene->getSceneTimeId(), 'current_user' => $this->getUser())),
			'scene_comment_form' => $this->getComponent('scene', 'sceneViewCommentForm', array('scene_time_id' => $scene->getSceneTimeId(), 'current_user' => $this->getUser())),
			'scene_description' => $this->getComponent('scene', 'sceneViewDescription', array('control_scene_times' => $this->control_scene_times, 'scene_id' => $this->scene_id)),
			'scene_social_buttons' => $this->getComponent('scene', 'sceneViewSocialButtons', array('scene_id' => $this->scene_id, 'user' => $scene->getSfGuardUserProfile(), 'current_user' => $this->getUser())),
			'rating_url' => $this->generateUrl('scene_post_comment_rating')
		);

		if($request->getParameter('modal'))
		{
			$stop_and_auth = false;
			if($request->getParameter('new_user') && !$this->getUser()->getId())
			{
				$stop_and_auth = true;
			}

			$return_array['scene_embed'] = $this->getComponent('scene', 'sceneViewEmbed', array('scene_time' => $scene->getSceneTime()->getSceneTime(), 'reclip' => $scene->getSceneTime()->getReclip(), 'modal' => 1, 'stop_and_auth' => $stop_and_auth));
			$return_array['scene_controls'] = $this->getComponent('scene', 'sceneViewControl', array('control_scene_times' => $this->control_scene_times, 'board_id' => $scene->getBoardId(), 'reclip_id' => $scene->getSceneTime()->getReclipId(), 'scene_id' => $scene->getId(), 'current_user' => $this->getUser(), 'modal' => 1));
			$return_array['owner_text'] = link_to($scene->getSfGuardUserProfile()->getFullName(), array('sf_route' => 'user', 'nick' => $scene->getSfGuardUserProfile()->getNick()));
			$return_array['owner_avatar'] = link_to(image_tag(ImagePreview::c14n($scene->getSfGuardUserProfileId(), 'medium', 'avatar')), array('sf_route' => 'user', 'nick' => $scene->getSfGuardUserProfile()->getNick()));
			$return_array['owner_button'] = $this->getUser()->getId() && $scene->getSfGuardUserProfileId() != $this->getUser()->getId() ? $this->getComponent('user', 'follow', array(
					'state_names' => array('Follow Person', 'Unfollow Person', 'Edit'),
					'sf_routes' => array('follow_user', 'unfollow_user', 'edit_user'),
					'id_key' => 'user_id',
					'id' => $scene->getSfGuardUserProfileId(),
					'active' => $this->getUser()->getId() == $scene->getSfGuardUserProfileId() ? 'my' : UserFollowerPeer::isUserFollowedByUser($scene->getSfGuardUserProfileId(), $this->getUser()->getId())
				)) : '';

			$return_array['board'] = $this->getComponent('board', 'boardStickerModal', array('board_id' => $scene->getBoardId(), 'current_user' => $this->getUser(), 'user' => $scene->getSfGuardUserProfile()));
			$return_array['people_modal'] = $this->getComponent('scene', 'peopleForSceneModal', array('scene_id' => $this->scene_id));


			///////////////
			$new_scene = clone($scene);
			$new_scene->setNew(true);
			$new_scene->fromArray(array(
				'Id' => null,
				'CreatedAt' => time(),
				'SfGuardUserProfileId' => $this->getUser()->getId(),
				'RepinOriginSceneId' => ($new_scene->getRepinOriginSceneId()) ? $new_scene->getRepinOriginSceneId() : $scene->getId()
			));

			$repin_form = new RepinModalForm($new_scene, array('sf_guard_user_profile_id' => $this->getUser()->getId()));
			///////////////
			$return_array['repin_form'] = $this->getPartial('scene/repinFormFields', array('form' => $repin_form));

			$new_scene_form = new SceneTimeForm(null, array('reclip_id' => $scene->getSceneTime()->getReclipId(), 'sf_guard_user_profile_id' => $this->getUser()->getId()));
			$return_array['new_scene_form'] = $this->getPartial('scene/modalFormFields', array('form' => $new_scene_form));
		}
		else
		{
			$return_array['nav_path'] = buildNavigationPath($scene);
			$return_array['nav_avatar'] = link_to(image_tag(ImagePreview::c14n($scene->getSfGuardUserProfileId(), 'medium', 'avatar')), array('sf_route' => 'user', 'nick' => $scene->getSfGuardUserProfile()->getNick()));
			$return_array['scene_people_sticker'] = $this->getComponent('scene', 'peopleForSceneSticker', array('scene_id' => $this->scene_id));
		}

		return $this->returnJSON($return_array);
	}

	public function executePostScene(sfWebRequest $request)
	{
		$this->scene_time_form = new SceneTimeForm(null, array(
			'created_at' => time(),
			'sf_guard_user_profile_id' => $this->getUser()->getId(),
		));

		$this->scene_time_form->bind($request->getParameter($this->scene_time_form->getName()));

		//Логгировать причину невалидности
		$this->forward404Unless($this->scene_time_form->isValid());

		$binded_values = $this->scene_time_form->getValues();
		$this->getResponse()->setCookie('post_facebook', $binded_values['post_facebook']);
		$this->scene_time_form->save();

		if($cache = $this->getContext()->getViewCacheManager())
		{
			$cache->remove('@sf_cache_partial?module=board&action=_clipSticker&sf_cache_key='.$this->scene_time_form->getObject()->getReclipId().'*');
			$cache->remove('@sf_cache_partial?module=board&action=_boardSticker&sf_cache_key='.$this->scene_time_form->getEmbeddedForm('scene')->getObject()->getBoardId().'*');
			$cache->remove('@sf_cache_partial?module=board&action=_clipStickerLogic&sf_cache_key='.$this->scene_time_form->getObject()->getReclip()->getClip()->getUrl().'*');
			$cache->remove('@sf_cache_partial?module=board&action=_clipStickerLogic&sf_cache_key='.$this->scene_time_form->getObject()->getReclipId().'*');
			$cache->remove('@sf_cache_partial?module=home&action=_clipList&sf_cache_key='.$this->getUser()->getId().'*');
		}

		$scene = $this->scene_time_form->getEmbeddedForm('scene')->getObject();

		if($binded_values['post_facebook'])
		{
			$fb_helper = new FB($this->getUser());
			$ext_id = $fb_helper->postLink($this->generateUrl('scene', array(
				'username_slug' => $this->getUser()->getNick(),
				'board_id' => $scene->getBoardId(),
				'id' => $scene->getId()
			), true), $scene->getText(), $scene->getSceneTime()->getReclip()->getClip()->getUrl(), $scene->getSceneTime()->getSceneTime(), $scene->getSceneTime()->getReclip()->getClipId());

			if($ext_id)
			{
				$scene->setExtId($ext_id);
				$scene->save();
			}
		}

		$url = $this->generateUrl('scene', array(
			'username_slug' => $this->getUser()->getNick(),
			'board_id' => $scene->getBoardId(),
			'id' => $scene->getId()
		));
		$this->redirect($url);
		return sfView::NONE;
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

		if($cache = $this->getContext()->getViewCacheManager())
		{
			$cache->remove('@sf_cache_partial?module=board&action=_clipSticker&sf_cache_key='.$this->scene_comment_form->getObject()->getSceneTime()->getReclipId().'*');
		}

		$partial = 'scene/sceneViewComment';
		if($request->getParameter('sticker'))
		{
			$partial = 'board/clipStickerSceneTimeComment';
		}

		return $this->returnJSON(array(
			'scene_new_comment' => $this->getPartial($partial, array('comment' => $this->scene_comment_form->getObject(), 'current_user' => $this->getUser(), 'ajax' => true, 'has_voted' => true)),
		));
	}

	public function executePostCommentRating(sfWebRequest $request)
	{
		$this->forward404Unless($request->getMethod() == sfRequest::POST && $this->getUser()->getId());

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

		if(SceneRepinPeer::toggleBySceneIdAndUserIdByState($request->getParameter('scene_id'), $this->getUser()->getId(), false)
				== SceneRepinPeer::UN_PINNED)
		{
			$result = array('result' => 'success', 'location' => url_for(array(
										'sf_route' => 'scene',
										'username_slug' => $origin_scene->getSfGuardUserProfile()->getNick(),
										'board_id' => $origin_scene->getBoardId(),
										'id' => $origin_scene->getId())), 'content' => 'toggled successfully');
			if($cache = $this->getContext()->getViewCacheManager())
			{
				$cache->remove('@sf_cache_partial?module=board&action=_clipSticker&sf_cache_key='.$origin_scene->getSceneTime()->getReclipId().'*');
			}
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

		if($cache = $this->getContext()->getViewCacheManager())
		{
			$cache->remove('@sf_cache_partial?module=board&action=_clipSticker&sf_cache_key='.$this->scene_form->getObject()->getSceneTime()->getReclipId().'*');
		}

		$this->redirect($this->generateUrl('scene', array(
			'username_slug' => $this->getUser()->getNick(),
			'board_id' => $this->scene_form->getObject()->getBoardId(),
			'id' => $this->scene_form->getObject()->getId()
		)));
	}

	public function executeToggleFBLikeState(sfWebRequest $request)
	{
		if($cache = $this->getContext()->getViewCacheManager())
		{
			$origin_scene = ScenePeer::retrieveByPK($request->getParameter('scene_id'));
			$cache->remove('@sf_cache_partial?module=board&action=_clipSticker&sf_cache_key='.$origin_scene->getSceneTime()->getReclipId().'*');
		}

		//Блядь, Максим, я тебя ненавижу, бочарик блядь.
		if ($this->getUser()->getId() != $request->getParameter('user_id'))
			return $this->returnJSON(array('code' => 403, 'content' => 'forbidden'));

		return (SceneLikePeer::toggleBySceneIdAndUserIdByState($request->getParameter('scene_id'),
                                                               $request->getParameter('user_id'),
                                                               $request->getParameter('state'))) ?

				$this->returnJSON(array('code' => 200, 'content' => 'toggled successfully')) :
				$this->returnJSON(array('code' => 500, 'content' => 'something wrong')) ;

	}
}
