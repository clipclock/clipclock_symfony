
	<?php include_component('user', 'navigationPerson', array('subject' => $user, 'active' => 'likes', 'current_user' => $current_user, 'user' => $user,
           'follow_button' => $current_user->getId() && $user->getId() != $current_user->getId() ? get_component('user', 'follow', array(
                                'state_names' => array('Follow Person', 'Unfollow Person', 'Edit'),
                                'sf_routes' => array('follow_user', 'unfollow_user', 'edit_user'),
                                'id_key' => 'user_id',
                                'id' => $user->getId(),
                                'active' => $current_user->getId() == $user->getId() ? 'my' : UserFollowerPeer::isUserFollowedByUser($user->getId(), $current_user->getId())
                                )) : ''))?>

<div class="content-wrap-in">
	<!-- side-left-col  -->
	<div class="side-left-col">
		<!-- follow-user  -->
		<div class="follow-user">
			<?php include_component('user', 'info', array('user' => $user)) ?>
			<?php include_component('user', 'followersList', array('user' => $user)) ?>
			<?php include_component('user', 'history', array('user' => $user)) ?>
		</div>
		<?php include_component('board', 'boardsLinked', array('user' => $user, 'current_user' => $current_user)) ?>
	</div>
	<div class="long-col">
		<div class="video-stickers">
		<ul id="container" class="stickers-list" style="position: relative;">
			<?php include_component('user', 'likes', array('user' => $user, 'pager' => $pager, 'current_user' => $current_user)) ?>
		</ul>
		</div>
		<script type="text/javascript">
			layoutAndScroll('<?php echo url_for('my_likes_page', array('nick' => $user->getNick(), 'page' => $pager->getNextPage())) ?>');
		</script>
	</div>
</div>
