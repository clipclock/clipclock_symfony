<?php foreach($comments as $comment):?>
	<?php include_partial('scene/sceneViewComment', array('comment' => $comment, 'current_user' => $current_user, 'has_voted' => isset($my_votes[$comment->getId()]) || $comment->getSfGuardUserProfileId() == $current_user->getId() ? true : false))?>
<?php endforeach?>