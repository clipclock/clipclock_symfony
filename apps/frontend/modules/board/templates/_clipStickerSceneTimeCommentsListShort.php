<ul class="tabs-items">
	<li class="active">
		<div class="b-comment">
			<div class="inside">
				<div class="ph"><a href="<?php echo url_for('user', array('nick' => $scene_info['nick']))?>"><img src="<?php echo ImagePreview::c14n($scene_info['user_id'], 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
				<p><a href="<?php echo url_for('user', array('nick' => $scene_info['nick']))?>"><?php echo $scene_info['nick'];?></a> <?php echo $scene_info['text'];?></p>
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