<li class="clip_sticker">
	<div class="inner">
		<p class="name-of-scence"><a href="<?php echo url_for('scene', array('id' => $scene_info['scene_id'], 'board_id' => $board->getId(), 'username_slug' => $board->getSfGuardUserProfile()))?>"><?php echo truncate_text($scene_info['name'], 32, '…', true)?></a></p>

		<div class="b-video">
			<div id="image_<?php echo $reclip_id ?>">
				<?php include_component('board', 'clipStickerSceneTimePreview', array('scene_info' => $scene_info, 'reclip_id' => $reclip_id, 'board' => $board))?>
			</div>
		</div>

		<div class="ajax_toogle_container_<?php echo $reclip_id ?> b-tabs">
			<?php include_component('board', 'clipStickerControl', array('board_id' => $board->getId(), 'reclip_id' => $reclip_id, 'scene_info' => $scene_info))?>

			<div class="ajax_toogle_<?php echo $reclip_id ?>">
				<div id="comments_list_<?php echo $reclip_id ?>">
					<?php include_component('board', 'clipStickerSceneTimeCommentsListShort', array('scene_info' => $scene_info, 'user' => $sf_user, 'reclip_id' => $reclip_id))?>
				</div>
				<div id="comments_list_footer_<?php echo $reclip_id ?>">
					<?php include_component('board', 'clipStickerFooter', array('scene_info' => $scene_info))?>
				</div>
			</div>
		</div>
	</div>
</li>
	<script type="text/javascript">
		stickerClick('<?php echo $reclip_id ?>', '<?php echo url_for('scene_change', array('scene_id' => $scene_info['scene_id'], 'modal' => true)); ?>', '<?php echo url_for('scene', array('id' => $scene_info['scene_id'], 'board_id' => $board->getId(), 'username_slug' => $board->getSfGuardUserProfile()), true); ?>', '<?php echo url_for('@scene_change?scene_id='.$scene_info['scene_id'])?>', '<?php echo $scene_info['scene_time']?>', '<?php echo $scene_info['scene_id']?>');
	</script>