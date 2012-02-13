<?php echo $clip_scenes_images[$clip_main_scene->getId()]?><br />
<?php foreach($clip_scenes as $clip_scene):?>
	<?php foreach($clip_scene->getSceneCommentsJoinSfGuardUserProfile()->getIterator() as $comment):?>
		<?php echo $comment?><br />
	<?php endforeach?>
<?php endforeach?>