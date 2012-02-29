<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('reclip_id' => $clip_id['reclip_id'], 'current_user' => $current_user))?>
<?php endforeach?>