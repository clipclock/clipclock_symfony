<?php foreach($boards as $board):?>
	<?php include_component('board', 'boardSticker', array('board_id' => $board->getId(), 'user' => $user))?>
<?php endforeach?>