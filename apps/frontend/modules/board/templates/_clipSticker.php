<li class="clip_sticker">
	<div class="inner">
		<div id="image_<?php echo $clip_id ?>" class="b-video">
			<?php include_component('board', 'clipStickerSceneTimePreview', array('scene_id' => $current_scene_id['id']))?>
		</div>

		<div class="b-tabs">
			<ul id="clip_control_<?php echo $clip_id ?>" class="tabs">
				<?php include_component('board', 'clipStickerControl', array('board_id' => $board_id, 'clip_id' => $clip_id))?>
			</ul>

			<div id="comments_list_<?php echo $clip_id ?>">
				<?php include_component('board', 'clipStickerSceneTimeCommentsListShort', array('scene_id' => $current_scene_id['id'], 'unique_comments_count' => $current_scene_id['unique_comments_count']))?>
			</div>
			<div id="comments_list_footer_<?php echo $clip_id ?>">
				<?php include_component('board', 'clipStickerFooter', array('scene_id' => $current_scene_id['id']))?>
			</div>
		</div>
	</div>
</li>