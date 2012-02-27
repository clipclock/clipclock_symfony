<?php include_component('user', 'navigationPath', array('subject' => $current_board, 'current_user' => $current_user, 'user' => $user,
           'follow_button' => get_component('user', 'follow', array(
                                'state_names' => array('Follow Set', 'Unfollow Set'),
                                'sf_routes' => array('follow_board', 'unfollow_board'),
                                'id_key' => 'board_id',
                                'id' => $current_board->getId(),
                                'active' => BoardFollowerPeer::isBoardFollowedByUser($current_board->getId(), $current_user->getId())
                                ))))?>

<div class="b-content">
<div class="content-wrap-in">
	<div class="side-left-col">
		<?php include_component('board', 'boardsLinked', array('current_board' => $current_board, 'user' => $user, 'current_user' => $current_user)) ?>
	</div>
	<div class="long-col">
		<?php include_component('board', 'boardClipsList', array('current_board' => $current_board)) ?>
	</div>
</div>
</div>