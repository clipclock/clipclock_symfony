<div class="b-comment">
	<div class="inside">
		<div class="ph">
			<a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><img src="<?php echo ImagePreview::c14n($comment->getSfGuardUserProfile()->getId(), 'small', 'avatar');?>" alt="" width="50" height="50" /></a>
		</div>
		<p>
			<a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><?php echo $comment->getSfGuardUserProfile()?></a>
			<span class="text"><?php echo $comment->getText()?></span>
		</p>
		<!-- rating  -->
		<!--ul class="rating">
			<li class="txt pls">+5</li>
			<li class="arrow min"></li>
			<li class="arrow max"></li>
		</ul-->
		<!-- /rating -->
	</div>
</div>