<?php if(count($liked_user_ids) || count($repined_user_ids)):?>
	<?php if(count($liked_user_ids)):?>
		<?php echo count($liked_user_ids)?> like<?php echo count($liked_user_ids) > 1 ? 's' : '' ?>
		<?php foreach($liked_user_ids as $liked_user_id):?>
			<?php include_component('scene', 'peopleForSceneStickerUser', array('user_id' => $liked_user_id['like_sf_guard_user_profile_id']))?>
		<?php endforeach ?>
	<?php endif;?>
	<?php if(count($repined_user_ids)):?>
		<?php echo count($repined_user_ids)?> like<?php echo count($repined_user_ids) > 1 ? 's' : '' ?>
		<?php foreach($repined_user_ids as $repined_user_id):?>
			<?php include_component('scene', 'peopleForSceneStickerUser', array('user_id' => $repined_user_id['repin_sf_guard_user_profile_id']))?>
		<?php endforeach ?>
	<?php endif;?>
<?php endif;?>
<br />