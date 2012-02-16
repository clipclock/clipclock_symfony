<hr />
<?php foreach($comments as $comment):?>
	<?php echo $comment->getCreatedAt()?><br />
	<?php echo $comment->getSfGuardUserProfile()?><br />
	<?php echo $comment->getText()?><br />
<?php endforeach?>