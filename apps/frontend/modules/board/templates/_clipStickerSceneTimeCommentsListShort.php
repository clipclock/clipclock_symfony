<?php echo $scene->getSfGuardUserProfile();?><br />
<?php echo $scene->getText();?>
<hr />
<?php foreach($comments as $comment):?>
	<?php echo $comment->getCreatedAt()?><br />
	<?php echo $comment->getSfGuardUserProfile()?><br />
	<?php echo $comment->getText()?><br />
<?php endforeach?>

<div class="footer">
	<?php include_component('board', 'clipStickerFooter', array('scene_id' => $scene_id, 'scene_time_id' => $scene->getSceneTimeId()))?>
</div>