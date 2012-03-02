<?php if(count($liked_user_ids) || count($repined_user_ids)):?>
<div class="round-b-default">
<div class="b-people">
	<?php if(count($liked_user_ids)):?>
		<div class="b-follow">
			<div class="title"><a href="<?php echo url_for('list_likes', array('username_slug' => $scene->getSfGuardUserProfile(), 'board_id' => $scene->getBoardId(), 'id' => $scene->getId()))?>"><strong><?php echo count($liked_user_ids)?></strong> like<?php echo count($liked_user_ids) > 1 ? 's' : '' ?></a></div>
			<ul>
			<?php foreach($liked_user_ids as $liked_user_id):?>
				<?php include_component('scene', 'peopleForSceneStickerUser', array('user_id' => $liked_user_id['like_sf_guard_user_profile_id'], 'scene' => $scene))?>
			<?php endforeach ?>
			</ul>
		</div>
	<?php endif;?>
	<?php if(count($repined_user_ids)):?>
		<div class="b-follow">
			<div class="title"><a href="<?php echo url_for('list_repins', array('username_slug' => $scene->getSfGuardUserProfile(), 'board_id' => $scene->getBoardId(), 'id' => $scene->getId()))?>"><strong><?php echo count($repined_user_ids)?></strong> repin<?php echo count($repined_user_ids) > 1 ? 's' : '' ?></a></div>
			<ul>
			<?php foreach($repined_user_ids as $repined_user_id):?>
				<?php include_component('scene', 'peopleForSceneStickerUser', array('user_id' => $repined_user_id['repin_sf_guard_user_profile_id'], 'scene' => $scene))?>
			<?php endforeach ?>
			</ul>
		</div>
	<?php endif;?>
	</div>
</div>

<?php endif;?>