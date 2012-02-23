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

<script type="text/javascript">
	repinClip();
</script>

<?php slot('repin_modal') ?>
<div id='new_repin_modal' style="display: none;" class="pop-window">
	<form method="post" action="<?php echo url_for('scene_repin');?>">
	<div class="close"></div>
	<!-- b-header  -->
	<div class="b-header">
		<h2>Add a video scene 01:32 in the set</h2>
	</div>
	<!-- /b-header -->
	<!-- b-content  -->
	<div class="b-content">
		<div class="add-video-scene">
				<?php echo $form->renderHiddenFields()?>
				<!-- video-descriptions  -->
				<div class="video-descriptions">
					<div class="line-form">
						<?php echo $form['board_id']?>
					</div>
				</div>
				<!-- /video-descriptions -->

		</div>
	</div>
	<!-- /b-content -->
	<!-- b-footer  -->
	<div class="b-footer">
		<div class="b-btn">
			<input name="" type="reset" class="default-un-follow-btn" value="Cancel">
			<input name="" type="submit" class="default-follow-btn" value="Done">
		</div>
	</div>
	</form>
	<!-- /b-footer -->
</div>
<?php end_slot(); ?>
<?php if(!ScenePeer::isRepinnedSceneByUser($origin_scene_id, $user->getId())) : ?>
    <div id="new_repin" class="new-tag">repin</div>
<?php else :?>
    <div id="un_repin" class="new-tag" href="<?php echo url_for('@scene_unrepin'); ?>" scene_id="<?php echo $origin_scene_id; ?>" user_id="<?php echo $user->getId(); ?>">unrepin</div>
<?php endif; ?>