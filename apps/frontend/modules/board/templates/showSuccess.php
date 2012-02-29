<div class="b-content">
<?php include_component('user', 'navigationPath', array('subject' => $current_board, 'current_user' => $current_user, 'user' => $user,
           'follow_button' => get_component('user', 'follow', array(
                                'state_names' => array('Follow Set', 'Unfollow Set', 'Edit'),
                                'sf_routes' => array('follow_board', 'unfollow_board', 'edit_board'),
                                'id_key' => 'board_id',
                                'id' => $current_board->getId(),
                                'active' => $current_user->getId() == $user->getId() ? 'my' : BoardFollowerPeer::isBoardFollowedByUser($current_board->getId(), $current_user->getId())
                                ))))?>
<div class="content-wrap-in">
	<div class="side-left-col">
		<?php include_component('board', 'boardsLinked', array('current_board' => $current_board, 'user' => $user, 'current_user' => $current_user)) ?>
	</div>
	<div class="long-col">
		<div class="video-stickers">
			<ul id="container" class="stickers-list" style="position: relative;">
				<?php include_component('board', 'boardClipsList', array('current_board' => $current_board, 'pager' => $pager)) ?>
			</ul>
			<?php echo jq_link_to_remote('next', array(
			'update' => array('success_callback' => 'console.log(JSON.parse(data));', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
			'url'    => '@board_page?page=3&id='.$current_board->getId().'&username_slug='.$current_user->getNick(),
			'method' => 'GET'
			))?>
			<script type="text/javascript">
				var handler = $('.clip_sticker').wookmark({
					container: $('#container'),
					offset: 5,
					itemWidth: 235,
					autoResize: true
				});
			</script>
		</div>
	</div>
</div>
</div>