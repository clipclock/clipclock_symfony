<?php if(count($liked_user_ids) || count($repined_user_ids)):?>
	<?php if(count($liked_user_ids)):?>
	<div class="b-people-likes">
		<h2><strong><a href="<?php echo url_for('list_likes', array('username_slug' => $scene->getSfGuardUserProfile(), 'board_id' => $scene->getBoardId(), 'id' => $scene->getId()))?>"><?php echo count($liked_user_ids)?> Like<?php echo count($liked_user_ids) > 1 ? 's' : '' ?></a></strong></h2>
		<ul class="list">
			<?php foreach($liked_user_ids as $liked_user_id):?>
			<?php include_component('scene', 'peopleForSceneStickerUser', array('user_id' => $liked_user_id['like_sf_guard_user_profile_id'], 'scene' => $scene, 'modal' => true))?>
			<?php endforeach ?>
		</ul>
	</div>
	<!-- /b-people-likes -->
	<?php endif;?>
	<?php if(count($repined_user_ids)):?>
	<!-- b-clip  -->
	<div class="b-clip">
		<h2><strong><a href="<?php echo url_for('list_repins', array('username_slug' => $scene->getSfGuardUserProfile(), 'board_id' => $scene->getBoardId(), 'id' => $scene->getId()))?>"><?php echo count($repined_user_ids)?> Reclip<?php echo count($repined_user_ids) > 1 ? 's' : '' ?></a></strong></h2>
		<div class="container">
			<ul class="list">
				<?php $i = 1 ;foreach($repined_user_ids as $repined_user_id):?>
					<?php if($i == 5):?>
						</ul>
						<ul class="list">
					<?php endif;?>
					<?php include_component('scene', 'peopleForSceneStickerUserReclip', array('user_id' => $repined_user_id['repin_sf_guard_user_profile_id'], 'board_name' => $repined_user_id['name'], 'scene' => $scene, 'modal' => true)); $i++;?>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<?php endif;?>
<?php endif;?>