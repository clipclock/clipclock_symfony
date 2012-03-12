<div class="b-comment"<?php echo isset($ajax) && $ajax == true ? ' style="display: none";' : ''; ?>>
	<div class="inside">
		<div class="ph">
			<a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><img src="<?php echo ImagePreview::c14n($comment->getSfGuardUserProfile()->getId(), 'medium', 'avatar');?>" alt="" width="50" height="50" /></a>
		</div>
		<p>
			<a href="<?php echo url_for('user', $comment->getSfGuardUserProfile())?>"><?php echo $comment->getSfGuardUserProfile()->getFullName()?></a>
			<span class="text"><?php echo $comment->getText()?></span>
		</p>
		<!-- rating  -->
			<ul id="comment_<?php echo $comment->getId()?>" class="rating ajax_toogle_container_<?php echo $comment->getId()?>">
				<div class="ajax_toogle_<?php echo $comment->getId()?>">
				<?php if($current_user->getId() && !$has_voted):?>
				<li class="arrow min"></li>
				<li class="arrow max"></li>
				<?php endif;?>
				<?php include_partial('scene/sceneViewCommentRating', array('rating' => $comment->getRating()))?>
				</div>
			</ul>
		<!-- /rating -->
	</div>
</div>