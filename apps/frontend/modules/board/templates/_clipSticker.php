<div id="image_<?php echo $clip_id ?>" class="image">
	<?php include_component('board', 'clipStickerSceneTimePreview', array('scene_id' => $current_scene_id['id']))?>
</div>

<div class="control">
	<?php include_component('board', 'clipStickerControl', array('board_id' => $board_id, 'clip_id' => $clip_id))?>
</div>

<div id="comments_list_<?php echo $clip_id ?>" class="comments">
	<?php include_component('board', 'clipStickerSceneTimeCommentsListShort', array('scene_id' => $current_scene_id['id'], 'unique_comments_count' => $current_scene_id['unique_comments_count']))?>
</div>