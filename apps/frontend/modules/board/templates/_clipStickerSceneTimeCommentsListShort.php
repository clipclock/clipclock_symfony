<ul class="tabs-items">
	<li class="active">
		<div class="b-comment">
			<div class="inside">
				<div class="ph"><a href="<?php echo url_for('user', $scene->getSfGuardUserProfile())?>"><img src="<?php echo ImagePreview::c14n($scene->getSfGuardUserProfile()->getId(), 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
				<p><a href="<?php echo url_for('user', $scene->getSfGuardUserProfile())?>"><?php echo $scene->getSfGuardUserProfile();?></a> <?php echo $scene->getText();?></p>
			</div>
		</div>
	<?php foreach($comments as $key => $comment):?>
		<div class="b-comment">
			<div class="inside">
				<div class="ph"><a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><img src="<?php echo ImagePreview::c14n($comment->getSfGuardUserProfile()->getId(), 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
				<p><a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><?php echo $comment->getSfGuardUserProfile()?></a> <?php echo $comment->getText()?></p>
			</div>
		</div>
	<?php endforeach;?>
	</li>
</ul>