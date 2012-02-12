<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('clip_id' => $clip_id['clip_id']))?>
<?php endforeach?>