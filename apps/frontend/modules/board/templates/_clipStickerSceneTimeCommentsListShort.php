<ul class="tabs-items">
	<li class="active">
		<div class="b-comment">
			<div class="inside">
				<div class="ph"><a href="<?php echo url_for('user', array('nick' => $scene_info['nick']))?>"><img src="<?php echo ImagePreview::c14n($scene_info['user_id'], 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
				<p><a href="<?php echo url_for('user', array('nick' => $scene_info['nick']))?>"><?php echo $scene_info['first_name'] . ' '.$scene_info['last_name'];?></a><br /><?php echo truncate_text($scene_info['text'], 140, '…', true);?></p>
			</div>
		</div>
	<?php foreach($comments as $key => $comment):?>
		<div class="b-comment">
			<div class="inside">
				<div class="ph"><a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><img src="<?php echo ImagePreview::c14n($comment->getSfGuardUserProfile()->getId(), 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
				<p><a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><?php echo $comment->getSfGuardUserProfile()->getFullName()?></a><br /><?php echo truncate_text($comment->getText(), 140, '…', true)?></p>
			</div>
		</div>
	<?php endforeach;?>
	</li>
</ul>