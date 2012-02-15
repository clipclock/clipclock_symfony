<?php foreach($scene_times as $scene_time):?>
	<?php echo jq_link_to_remote(date('i:s', mktime(0, 0, $scene_time['scene_time'])), array(
		'update' => array('success_callback' => 'stickerChange(data, "'.$clip_id.'");', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
		'url'    => '@sticker_scene_change?scene_id='.$scene_time['id'],
		'method' => 'GET'
	))?>
<?php endforeach;?>