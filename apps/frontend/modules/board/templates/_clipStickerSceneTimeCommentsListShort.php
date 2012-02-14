
<?php foreach($comments as $comment):?>
	<?php echo $comment->getCreatedAt()?><br />
	<?php echo $comment->getSfGuardUserProfile()?><br />
	<?php echo $comment->getText()?><br />
<?php endforeach?>

<div class="footer">
	<?php include_component('board', 'clipStickerFooter', array('current_scene_id' => $current_scene_id, 'current_scene_time_id' => $comment->getSceneTimeId()))?>
</div>