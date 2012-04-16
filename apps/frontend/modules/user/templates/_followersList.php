<?php if(count($followings) || count($followers)):?>
<div class="b-people">
	<?php if(count($followings)):?>
	<div class="b-follow following">
		<div class="title"><a href="<?php echo url_for('list_followings', array('nick' => $user->getNick()))?>"><strong><?php echo $followings_count?></strong> following</a></div>
		<ul>
			<?php foreach($followings as $following):?>
			<?php include_component('user', 'followersListUser', array('user_id' => $following['user_id']))?>
			<?php endforeach?>
		</ul>
	</div>
	<?php endif;?>
	<?php if(count($followers)):?>
	<div class="b-follow followers">
		<div class="title"><a href="<?php echo url_for('list_followers', array('nick' => $user->getNick()))?>"><strong><?php echo $followers_count?></strong> follower<?php echo $followers_count > 1 ? 's' : '' ?></a></div>
		<ul>
			<?php foreach($followers as $follower):?>
			<?php include_component('user', 'followersListUser', array('user_id' => $follower['user_id']))?>
			<?php endforeach?>
		</ul>
	</div>
	<?php endif;?>
</div>
<?php endif ?>