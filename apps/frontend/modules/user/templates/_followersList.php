Followings: <?php echo $followings_count?><br />
<?php foreach($followings as $following):?>
	<?php include_component('user', 'followersListUser', array('user_id' => $following['user_id']))?>
<?php endforeach?>
<br />
Followers: <?php echo $followers_count?><br />
<?php foreach($followers as $follower):?>
	<?php include_component('user', 'followersListUser', array('user_id' => $follower['user_id']))?>
<?php endforeach?>