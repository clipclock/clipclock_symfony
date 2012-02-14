<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('clip_id' => $clip_id['clip_id'], 'board_id' => $board->getId()))?>
<?php endforeach?>