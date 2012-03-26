<?php include_component('board', 'categoryPanel', array('board_id' => $current_board->getId(), 'user_id' => $current_user->getId()))?>
<div class="b-content">
<?php include_component('user', 'navigationPath', array('subject' => $current_board, 'current_user' => $current_user, 'user' => $user,
           'follow_button' => $current_user->getId() && $user->getId() != $current_user->getId() ? get_component('user', 'follow', array(
                                'state_names' => array('Follow Channel', 'Unfollow Channel', 'Edit'),
                                'sf_routes' => array('follow_board', 'unfollow_board', 'edit_board'),
                                'id_key' => 'board_id',
                                'id' => $current_board->getId(),
                                'active' => $current_user->getId() == $user->getId() ? 'my' : BoardFollowerPeer::isBoardFollowedByUser($current_board->getId(), $current_user->getId())
                                )) : ''))?>
<div class="content-wrap-in">
	<div class="side-left-col">
		<?php include_component('board', 'boardsLinked', array('current_board' => $current_board, 'user' => $user, 'current_user' => $current_user)) ?>
	</div>
	<div class="long-col">
		<div class="video-stickers">
			<ul id="container" class="stickers-list" style="position: relative;">
				<?php include_component('board', 'boardClipsList', array('current_board' => $current_board, 'pager' => $pager, 'current_user' => $current_user, 'user' => $user)) ?>
			</ul>
			<script type="text/javascript">
				layoutAndScroll('<?php echo url_for('board_page', array('id' => $current_board->getId(), 'username_slug' => $user->getNick(), 'page' => $pager->getNextPage())) ?>');
			</script>
		</div>
	</div>
</div>
</div>