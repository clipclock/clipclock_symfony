<li class="clip_sticker">
	<div class="inner">
		<div id="image_<?php echo $reclip_id ?>" class="b-video">
			<?php include_component('board', 'clipStickerSceneTimePreview', array('scene' => $scene))?>
		</div>

		<div class="b-tabs">
			<ul id="clip_control_<?php echo $reclip_id ?>" class="tabs">
				<?php include_component('board', 'clipStickerControl', array('board_id' => $board_id, 'reclip_id' => $reclip_id, 'scene' => $scene))?>
			</ul>

			<div id="comments_list_<?php echo $reclip_id ?>">
				<?php include_component('board', 'clipStickerSceneTimeCommentsListShort', array('scene' => $scene))?>
			</div>
			<div id="comments_list_footer_<?php echo $reclip_id ?>">
				<?php include_component('board', 'clipStickerFooter', array('scene' => $scene))?>
			</div>
		</div>
	</div>
</li>