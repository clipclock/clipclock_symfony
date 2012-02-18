Репинов: <?php echo $repins_count?><br />
Лайков: <?php echo $likes_count?>
<div id="fb-root"></div>

<script>
	<?php if($user->getId()):?>
		fbHooks(<?php echo sprintf('%d, %d', $scene_id, $user->getId()) ?>, "<?php echo url_for('@scene_change_liked_state'); ?>");
	<?php endif;?>

</script>
<fb:like send="false" layout="box_count" width="55" show_faces="true"></fb:like>

<br />
