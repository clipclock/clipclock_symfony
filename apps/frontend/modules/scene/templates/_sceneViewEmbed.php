<h2><?php echo $reclip->getClip()->getName()?></h2>
<div class="viewing">
<div id="scene_embed_video">
	<div id="scene_embed_video_player"><span></span></div>
</div>
</div>
<script type="text/javascript">

	redirectAterClose = '<?php echo url_for('connect_fb', array(), true)?>';

	asyncRequestor.call('youtube', function(){
		<?php if(isset($stop_and_auth) && $stop_and_auth):?>
			asyncRequestor.call('facebook', function(){
				FB.login(function(response) {
					if (response.authResponse) {
						toggleModalScene();
						window.location.href = redirectAterClose;
						return true;
					} else {
						embedClip(<?php echo $scene_time?>, '<?php echo $reclip->getClip()->getUrl()?>', '<?php echo $reclip->getClip()->getSource()->getName()?>', 'true'<?php echo isset($stop_and_auth) && $stop_and_auth ? ', true' : ', false'?>);
					}
				}, {scope: 'publish_actions,email'});
			});
		<?php else: ?>
			embedClip(<?php echo $scene_time?>, '<?php echo $reclip->getClip()->getUrl()?>', '<?php echo $reclip->getClip()->getSource()->getName()?>', 'true'<?php echo isset($stop_and_auth) && $stop_and_auth ? ', true' : ', false'?>);
		<?php endif?>
	});
</script>