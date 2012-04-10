<h2><?php echo $reclip->getClip()->getName()?></h2>
<div class="viewing">
<div id="scene_embed_video">
	<div id="scene_embed_video_player"><span></span></div>
</div>
</div>
<script type="text/javascript">
	function onYouTubePlayerAPIReady() {
		youTubeApiLoaded = 1;
		<?php if(isset($stop_and_auth) && $stop_and_auth):?>
			redirectAterClose = '<?php echo url_for('connect_fb', array(), true)?>';
			fbHooks(<?php echo $fb_app_id?>, false, false, false, '<?php echo url_for('invites_callback')?>');
		<?php endif?>

		embedClip(<?php echo $scene_time?>, '<?php echo $reclip->getClip()->getUrl()?>', '<?php echo $reclip->getClip()->getSource()->getName()?>', 'true'<?php echo isset($stop_and_auth) && $stop_and_auth ? ', true' : ', false'?>);
	}

	if (youTubeApiLoaded == 1){
		embedClip(<?php echo $scene_time?>, '<?php echo $reclip->getClip()->getUrl()?>', '<?php echo $reclip->getClip()->getSource()->getName()?>', 'true'<?php echo isset($stop_and_auth) && $stop_and_auth ? ', true' : ', false'?>);
	}
</script>