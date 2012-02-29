<?php include_component('scene', 'sceneViewEmbed', array('scene_time' => $scene_time->getSceneTime(), 'reclip' => $reclip))?>
<div class="b-tabs">
	<?php include_component('scene', 'sceneViewControl', array('board_id' => $scene->getBoardId(), 'reclip_id' => $reclip->getId(), 'scene_id' => $scene->getId()))?>
	<ul class="tabs-items">
		<li id='scene_add_comment' class="tag-new-cont">
			<!-- b-add-comment  -->
			<div class="b-add-comment">
				<div class="inside">
					<div class="ph">
						<a href="<?php echo url_for('user', $current_user)?>"><img src="<?php echo ImagePreview::c14n($current_user->getId(), 'medium', 'avatar');?>" alt="<?php echo $current_user?>" title="<?php echo $current_user?>" width="50" height="50" /></a>
					</div>
					<form method="get">
						<div class="brd">
							<span id="new_time_scene_time" style="display: none;"></span>
							<textarea id="new_time_scene_description" name="" cols="" rows=""></textarea>
						</div>
						<div class="b-btn">
							<input id="new_time_scene_description_container_submit" class="default-follow-btn" name="" type="button" value="Create scene" />
						</div>
					</form>
				</div>
			</div>
			<!-- /b-add-comment -->
		</li>
		<li id="scene_info" class="active">
			<div id="description" class="b-autor-text">
				<?php include_component('scene', 'sceneViewDescription', array('scene_id' => $scene->getId()))?>
			</div>
			<div id="comment_form" class="b-add-comment ajax_load_shadow">
				<?php include_component('scene', 'sceneViewCommentForm', array('scene_time_id' => $scene->getSceneTimeId(), 'current_user' => $current_user))?>
			</div>
			<div id="comments">
				<?php include_component('scene', 'sceneViewComments', array('scene_time_id' => $scene->getSceneTimeId()))?>
			</div>
		</li>
	</ul>
</div>