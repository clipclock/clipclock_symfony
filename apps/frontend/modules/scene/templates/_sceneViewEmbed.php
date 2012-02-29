<h2><?php echo $clip->getName()?></h2>
<div class="viewing">
<div id="scene_embed_video">
	<img src="/images/video.jpg" alt="" width="533" height="330" />
</div>
</div>
<script type="text/javascript">
	embedClip(<?php echo $scene_time?>, '<?php echo $clip->getUrl()?>', '<?php echo $clip->getSource()->getName()?>');
</script>