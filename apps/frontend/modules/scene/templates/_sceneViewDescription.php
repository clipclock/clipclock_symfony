<div class="inside">
	<div class="ph">
		<a href="<?php echo url_for('user', $scene->getSfGuardUserProfile())?>"><img src="<?php echo ImagePreview::c14n($scene->getSfGuardUserProfile()->getId(), 'medium', 'avatar');?>" alt="" width="50" height="50" /></a>
	</div>
	<p>
		<span class="t-bl"><a href="<?php echo url_for('user', $scene->getSfGuardUserProfile())?>"><?php echo $scene->getSfGuardUserProfile()?></a>, Pinned 2 hours ago from <strong>YouTube</strong></span>
		<?php echo $scene->getText()?>
	</p>
</div>