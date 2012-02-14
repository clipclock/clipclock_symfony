<div class="image">
	<?php include_component('board', 'clipStickerSceneTimePreview', array('scene_time_id' => $current_scene_id['scene_time_id']))?>
</div>

<div class="control">
	<?php include_component('board', 'clipStickerControl', array('board_id' => $board_id, 'clip_id' => $clip_id))?>
</div>

<div id="comments_<?php echo $clip_id ?>" class="comments">
	<?php include_component('board', 'clipStickerSceneTimeCommentsListShort', array('current_scene_id' => $current_scene_id['id'], 'unique_comments_count' => $current_scene_id['unique_comments_count']))?>
</div>