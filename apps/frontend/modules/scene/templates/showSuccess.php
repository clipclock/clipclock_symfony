<div class="b-content">
<?php include_component('user', 'navigationPath', array('subject' => $current_scene, 'current_user' => $current_user, 'user' => $user,
           'follow_button' => $current_user->getId() != $user->getId() ? get_component('user', 'follow', array(
                                'state_names' => array('Follow Video', 'Unfollow Video'),
                                'sf_routes' => array('follow_clip', 'unfollow_clip'),
                                'id_key' => 'clip_id',
                                'id' => $current_scene->getSceneTime()->getClipId(),
                                'active' => ClipFollowerPeer::isClipFollowedByUser($current_scene->getSceneTime()->getClipId(), $current_user->getId())
                                )) : ''))?>

<div class="content-wrap-in">
	<div class="side-left-col">
		<ul class="follow-set">
			<?php include_component('board', 'boardSticker', array('board_id' => $current_scene->getBoardId(), 'user' => $user, 'current_user' => $current_user))?>
		</ul>
		<?php include_component('scene', 'peopleForSceneSticker', array('scene_id' => $current_scene->getId()))?>
	</div>
	<div class="long-col">
		<div class="long-col-inside">
			<div class="right-mini-coll">
				<?php include_component('scene', 'sceneViewSocialButtons', array('scene_id' => $current_scene->getId(), 'user' => $user, 'current_user' => $current_user))?>
			</div>
			<div class="center-col">
				<div class="b-main-video">
					<?php include_component('scene', 'sceneView', array('scene' => $current_scene, 'user' => $user, 'current_user' => $current_user))?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>