<?php include_component('user', 'navigationPerson', array('subject' => $user, 'current_user' => $current_user, 'user' => $user,
           'follow_button' => get_component('user', 'follow', array(
                                'state_names' => array('Follow Person', 'Unfollow Person'),
                                'sf_routes' => array('follow_user', 'unfollow_user'),
                                'id_key' => 'user_id',
                                'id' => $user->getId(),
                                'active' => UserFollowerPeer::isUserFollowedByUser($user->getId(), $current_user->getId())
                                ))))?>


<div class="b-content">
<div class="content-wrap-in">
	<!-- side-left-col  -->
	<div class="side-left-col">
		<!-- follow-user  -->
		<div class="follow-user">
			<?php include_component('user', 'info', array('user' => $user)) ?>
			<?php include_component('user', 'followersList', array('user' => $user)) ?>
			<?php include_component('user', 'history', array('user' => $user)) ?>
		</div>
	</div>
	<div class="long-col">
		<?php include_component('user', 'boards', array('user' => $user, 'current_user' => $current_user)) ?>
	</div>
</div>
</div>