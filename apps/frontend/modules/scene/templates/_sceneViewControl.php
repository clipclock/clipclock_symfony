<?php foreach($scene_times as $scene_time):?>
	<?php if($scene_time['id'] == $scene_id){?>
		<?php echo date('i:s', mktime(0, 0, $scene_time['scene_time']))?>
	<?php }else{?>
		<?php echo jq_link_to_remote(date('i:s', mktime(0, 0, $scene_time['scene_time'])), array(
			'update' => array('success_callback' => 'console.log("123");', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
			'url'    => '@scene_change?scene_id='.$scene_time['id'],
			'method' => 'GET',
			'before' => 'switchTo('.$scene_time['scene_time'].');'
		))?>
	<?php }?>
<?php endforeach;?>
<a href="#" id="new_time_scene">New time tag</a>