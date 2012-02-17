<h2><?php echo $clip->getName()?></h2>
<div id="scene_embed_video">
	You need Flash player 8+ and JavaScript enabled to view this video.
</div>
<script type="text/javascript">
	embedClip('scene_embed_video', <?php echo $scene_time?>, '<?php echo $clip->getUrl()?>', '<?php echo $clip->getSource()->getName()?>');
</script>