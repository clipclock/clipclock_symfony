<ul class="follow-set">
<?php foreach($linked_boards_ids as $linked_board_id):?>
	<?php include_component('board', 'boardSticker', array('board_id' => $linked_board_id['id'], 'user' => $user, 'current_user' => $current_user, 'sf_cache_key' => $linked_board_id['id'].$current_user->getId()))?>
<?php endforeach?>
</ul>