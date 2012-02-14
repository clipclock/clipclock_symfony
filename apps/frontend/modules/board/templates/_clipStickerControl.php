<?php foreach($scene_times as $scene_time):?>
	<a href="/<?php echo $scene_time['id']?>"><?php echo date('i:s', mktime(0, 0, $scene_time['scene_time']))?></a>
<?php endforeach;?>