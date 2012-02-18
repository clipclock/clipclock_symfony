<div id="user_info">
	<?php include_component('user', 'info', array('user' => $user)) ?>
	<div id="user_followers_list">
		<?php include_component('user', 'followersList', array('user' => $user)) ?>
	</div>
	<div id="user_history">
		<?php include_component('user', 'history', array('user' => $user)) ?>
	</div>
</div>
<div id="user_boards">
	<?php include_component('user', 'boards', array('user' => $user)) ?>
</div>