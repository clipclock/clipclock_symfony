<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('clip_id' => $clip_id['clip_id'], 'current_user' => $current_user))?>
<?php endforeach?>