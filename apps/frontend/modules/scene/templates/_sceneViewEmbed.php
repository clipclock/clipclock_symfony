<h2><?php echo $reclip->getClip()->getName()?></h2>
<div class="viewing">
<div id="scene_embed_video">
	<div id="scene_embed_video_player"></div>
</div>
</div>
<script type="text/javascript">
	function onYouTubePlayerAPIReady() {
		embedClip(<?php echo $scene_time?>, '<?php echo $reclip->getClip()->getUrl()?>', '<?php echo $reclip->getClip()->getSource()->getName()?>', 'true');
	}
</script>