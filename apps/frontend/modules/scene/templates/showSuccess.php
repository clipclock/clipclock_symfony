<?php include_component('board', 'categoryPanel', array('board_id' => $current_scene->getBoardId(), 'user_id' => $current_user->getId()))?>

<?php include_component('user', 'navigationPath', array('subject' => $current_scene, 'current_user' => $current_user, 'user' => $user,
           'follow_button' => $current_user->getId() && $current_user->getId() != $user->getId() ? get_component('user', 'follow', array(
                                'state_names' => array('Follow Video', 'Unfollow Video'),
                                'sf_routes' => array('follow_clip', 'unfollow_clip'),
                                'id_key' => 'clip_id',
                                'id' => $current_scene->getSceneTime()->getReclip()->getClipId(),
                                'active' => ClipFollowerPeer::isClipFollowedByUser($current_scene->getSceneTime()->getReclip()->getClipId(), $current_user->getId())
                                )) : ''))?>

<div class="content-wrap-in" id="viewport">
	<div class="side-left-col">
		<ul id="boards_stickers" class="follow-set">
			<?php include_component('board', 'boardSticker', array('board_id' => $current_scene->getBoardId(), 'user' => $user, 'current_user' => $current_user))?>
		</ul>
		<div class="ajax_toogle_container">
			<div id="people_sticker" class="ajax_toogle">
				<?php include_component('scene', 'peopleForSceneSticker', array('scene_id' => $current_scene->getId()))?>
			</div>
		</div>
	</div>
	<div class="long-col-origin">
		<div class="long-col-inside">
			<?php if($current_user->getId()):?>
			<div class="right-mini-coll ajax_toogle_container">
				<div id="fun_buttons" class="ajax_toogle">
				<?php include_component('scene', 'sceneViewSocialButtons', array('scene_id' => $current_scene->getId(), 'user' => $user, 'current_user' => $current_user))?>
				</div>
			</div>
				<?php endif?>
			<div class="center-col">
				<div class="b-main-video">
					<?php include_component('scene', 'sceneView', array('scene' => $current_scene, 'user' => $user, 'current_user' => $current_user))?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	cuselActivate(6);
</script>