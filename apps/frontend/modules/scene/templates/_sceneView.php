<?php include_component('scene', 'sceneViewEmbed', array('scene_time' => $scene_time->getSceneTime(), 'reclip' => $reclip))?>
<div class="b-tabs">
	<?php include_component('scene', 'sceneViewControl', array('control_scene_times' => $control_scene_times, 'board_id' => $scene->getBoardId(), 'reclip_id' => $reclip->getId(), 'scene_id' => $scene->getId(), 'current_user' => $current_user))?>
	<ul class="tabs-items">
		<?php if($current_user->getId()):?>
		<li id='scene_add_comment' class="tag-new-cont">
			<?php include_partial('scene/sceneViewNewSceneForm', array('current_user' => $current_user, 'post_facebook' => $post_facebook))?>
		</li>
		<?php endif?>
		<li id="scene_info" class="active">
				<div id="description" class="b-autor-text">
					<?php include_component('scene', 'sceneViewDescription', array('control_scene_times' => $control_scene_times, 'scene_id' => $scene->getId()))?>
				</div>
			<div class="ajax_toogle_container">
			<div class="ajax_toogle">
				<?php if($current_user->getId()):?>
				<div id="comment_form" class="b-add-comment ajax_load_shadow">
					<?php include_component('scene', 'sceneViewCommentForm', array('scene_time_id' => $scene->getSceneTimeId(), 'current_user' => $current_user))?>
				</div>
				<?php endif?>
				<div id="comments">
					<?php include_component('scene', 'sceneViewComments', array('scene_time_id' => $scene->getSceneTimeId(), 'current_user' => $current_user))?>
				</div>
			</div>
			</div>
		</li>
		<script type="text/javascript">
			bindCommentRatingButtons('<?php echo url_for('scene_post_comment_rating')?>');
			_kmq.push(['record', 'Viewed video'], {'scene_id':<?php echo $scene->getId()?>});
		</script>
	</ul>
</div>