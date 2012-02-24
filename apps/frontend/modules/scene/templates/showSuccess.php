<div class="user-title">
    <!-- user-like  -->
    <div class="user-like">
        <!-- ph  -->
        <div class="ph">
            <a href="#"><img src="images/avatars/user-title-pic.jpg" alt="" width="50" height="50"></a>
        </div>
        <!-- /ph -->
        <!-- path  -->
        <div class="path">
            <a href="#">Alexey Rozzi</a> / <a href="#">Sport</a> / <a href="#">Big Sky Resort, Montana - Late January 2009</a> / 02:14
        </div>
        <!-- /path -->
        <!-- b-btn  -->
        <?php include_component('user', 'follow', array(
                                'state_names' => array('Follow Video', 'Unfollow Video'),
                                'sf_routes' => array('follow_clip', 'unfollow_clip'),
                                'id_key' => 'clip_id',
                                'id' => $current_scene->getSceneTime()->getClipId(),
                                'active' => ClipFollowerPeer::isClipFollowedByUser($current_scene->getSceneTime()->getClipId(), $current_user->getId())
        ))?>


        <!-- /b-btn -->
    </div>
    <!-- /user-like -->
</div>

    
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
				<?php include_component('scene', 'sceneViewSocialButtons', array('scene' => $current_scene))?>
			</div>
			<div class="center-col">
				<div class="b-main-video">
					<?php include_component('scene', 'sceneView', array('scene' => $current_scene))?>
				</div>
			</div>
		</div>
	</div>
</div>