<li class="clip_sticker">
	<div class="inner">
		<div class="b-video">
			<p class="scene_description"><a href="<?php echo url_for('scene', array('id' => $scene_info['scene_id'], 'board_id' => $board->getId(), 'username_slug' => $board->getSfGuardUserProfile()))?>"><?php echo truncate_text($scene_info['name'], 32, '…', true)?></a></p>
			<div id="image_<?php echo $reclip_id ?>">
				<?php include_component('board', 'clipStickerSceneTimePreview', array('scene_info' => $scene_info, 'reclip_id' => $reclip_id, 'board' => $board))?>
			</div>
		</div>

		<div class="ajax_toogle_container_<?php echo $reclip_id ?> b-tabs">
			<ul id="clip_control_<?php echo $reclip_id ?>" class="tabs">
				<?php include_component('board', 'clipStickerControl', array('board_id' => $board->getId(), 'reclip_id' => $reclip_id, 'scene_info' => $scene_info))?>
			</ul>

			<div class="ajax_toogle_<?php echo $reclip_id ?>">
				<div id="comments_list_<?php echo $reclip_id ?>">
					<?php include_component('board', 'clipStickerSceneTimeCommentsListShort', array('scene_info' => $scene_info))?>
				</div>
				<div id="comments_list_footer_<?php echo $reclip_id ?>">
					<?php include_component('board', 'clipStickerFooter', array('scene_info' => $scene_info))?>
				</div>
			</div>
		</div>
	</div>
</li>