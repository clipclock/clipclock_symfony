<li>
	<div class="user-pic">
		<a href="<?php echo url_for('user', array('nick' => $target_user))?>"><img src="<?php echo ImagePreview::c14n($user_id, 'medium', 'avatar');?>" alt="" width="50" height="50" /></a>
	</div>
	<div class="name"><a href="<?php echo url_for('user', array('nick' => $target_user))?>"><?php echo $target_user->getFullName()?></a></div>
	<?php $user->getId() ? include_component('user', 'follow', array(
		'state_names' => array('Follow Person', 'Unfollow Person', 'Edit'),
		'sf_routes' => array('follow_user', 'unfollow_user', 'edit_user'),
		'id_key' => 'user_id',
		'id' => $user_id,
		'active' => $user->getId() == $user_id ? 'my' : UserFollowerPeer::isUserFollowedByUser($user_id, $user->getId())
	)) : ''?>
	<div class="gallery">
		<div class="pins">Pins</div>
		<ul class="gall-photos">
			<?php foreach($scene_infos as $scene_info):?>
				<li><a href="<?php echo url_for('scene', array('id' => $scene_info['scene_id'], 'board_id' => $scene_info['board_id'], 'username_slug' => $scene_info['nick']))?>">
				<img src="<?php echo ImagePreview::c14n($scene_info['clip_id'].$scene_info['scene_time'], 'medium')?>" alt="" width="61" height="61" /></a></li>
			<?php endforeach?>
			<li class="transition"></li>
		</ul>
	</div>
</li>