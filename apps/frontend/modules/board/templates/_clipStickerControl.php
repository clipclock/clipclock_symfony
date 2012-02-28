<?php foreach($scene_times as $key => $scene_time):?>
	<li id='sticker_<?php echo $clip_id?>_<?php echo $scene_time['id']?>'<?php echo $scene_time['scene_time_id'] == $scene->getSceneTimeId() ? ' class="active"' : '' ?>><?php echo jq_link_to_remote(date('i:s', mktime(0, 0, $scene_time['scene_time'])), array(
		'update' => array('success_callback' => 'stickerChange(data, "'.$clip_id.'", "'.$scene_time['id'].'");', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
		'url'    => '@sticker_scene_change?scene_id='.$scene_time['id'],
		'method' => 'GET'
	))?></li>
<?php endforeach;?>
