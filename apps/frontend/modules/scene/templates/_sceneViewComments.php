<hr />
<?php foreach($comments as $comment):?>
	<?php include_partial('scene/sceneViewComment', array('comment' => $comment))?>
<?php endforeach?>