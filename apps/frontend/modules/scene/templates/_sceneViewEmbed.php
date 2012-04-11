<h2><?php echo $reclip->getClip()->getName()?></h2>
<div class="viewing">
<div id="scene_embed_video">
	<div id="scene_embed_video_player">
		<?php if(isset($stop_and_auth) && $stop_and_auth):?>
			<a href="<?php echo url_for('connect_fb')?>" class="fb_button">&nbsp;</a>
		<?php endif?>
	<span></span></div>
</div>
</div>
<script type="text/javascript">

	asyncRequestor.call('youtube', function(){
		embedClip(<?php echo $scene_time?>, '<?php echo $reclip->getClip()->getUrl()?>', '<?php echo $reclip->getClip()->getSource()->getName()?>', 'true'<?php echo isset($stop_and_auth) && $stop_and_auth ? ', true' : ', false'?>);
	});
</script>