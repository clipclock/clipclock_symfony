<ul id="clip_control_<?php echo $reclip_id ?>" class="tabs<?php echo count($scene_times) > 4 ? ' wide' : '' ?>">
	<?php if(count($scene_times) > 4):?><li class="arrow prev"></li><?php endif;?>
<?php
$active_key = 0;
$tabs_from_left = 1;
$tabs_to_hide = 0;
foreach($scene_times as $key => $scene_time)
{
	if($scene_time['scene_time_id'] == $scene_info['scene_time_id'])
	{
		$active_key = $key;
		break;
	}
	else
	{
		$tabs_from_left++;
	}
}
$tabs_to_hide = $tabs_from_left-4 > 0 ? $tabs_from_left-4 : 0;
if($tabs_from_left > 3 && count($scene_times) > 4 && count($scene_times) > $tabs_from_left)
{
	$tabs_to_hide++;
}
?>
<?php foreach($scene_times as $key => $scene_time):?>

	<li<?php if($tabs_to_hide):?> style="display: none"<?php endif;?> id='sticker_<?php echo $reclip_id?>_<?php echo $scene_time['id']?>' class="sticker-tab<?php echo $key == $active_key ? ' active' : '' ?>"><?php echo jq_link_to_remote(date('i:s', mktime(0, 0, $scene_time['scene_time'])), array(
		'update' => array('success_callback' => 'stickerChange(data, "'.$reclip_id.'", "'.$scene_time['id'].'");', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
		'url'    => '@sticker_scene_change?scene_id='.$scene_time['id'],
		'condition' => 'checkCurrentSticker('.$reclip_id.', '.$scene_time['id'].')',
		'method' => 'GET'
	))?></li>

	<?php if($tabs_to_hide){
		$tabs_to_hide--;
	}?>
<?php endforeach;?>
<?php if(count($scene_times) > 4):?><li class="arrow next"></li><?php endif; ?>
</ul>
<script type="text/javascript">
	stickerControlScrollers('clip_control_<?php echo $reclip_id ?>');
</script>