	<p>
	<?php echo $comment->getCreatedAt()?><br />
	<?php echo $comment->getSfGuardUserProfile()?><br />
	<pre>
		<?php echo $comment->getText()?><br />
	</pre>
	</p>