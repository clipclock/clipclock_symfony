<div class="b-comment"<?php echo isset($ajax) && $ajax == true ? ' style="display: none";' : ''; ?>>
	<div class="inside">
		<div class="ph"><a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><img src="<?php echo ImagePreview::c14n($comment->getSfGuardUserProfile()->getId(), 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
		<p><a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><?php echo $comment->getSfGuardUserProfile()->getFullName()?></a><?php echo truncate_text($comment->getText(), 140, '…', true)?></p>
	</div>
</div>