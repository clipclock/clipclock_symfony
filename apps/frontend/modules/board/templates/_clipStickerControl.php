<ul id="clip_control_<?php echo $reclip_id ?>" class="tabs<?php echo count($scene_times) > 4 ? ' wide' : '' ?>">
	<?php if(count($scene_times) > 4):?><li class="arrow prev"></li><?php endif;?>
<?php list($active_key, $tabs_to_hide) = getTabsHideOffset($scene_times, 'scene_time_id', $scene_info['scene_time_id']);?>
<?php foreach($scene_times as $key => $scene_time):?>
	<li<?php if($tabs_to_hide):?> style="display: none"<?php endif;?> id='sticker_<?php echo $reclip_id?>_<?php echo $scene_time['id']?>' class="sticker-tab<?php echo $key == $active_key ? ' active' : '' ?>">
		<a href="<?php echo url_for('@sticker_scene_change?scene_id=' . $scene_time['id']) ?>" data-reclip-id="<?php echo $reclip_id ?>" data-scene-id="<?php echo $scene_time['id'] ?>">
			<?php echo date('i:s', mktime(0, 0, $scene_time['scene_time'])) ?>
		</a>
	</li>
	<?php if($tabs_to_hide){
		$tabs_to_hide--;
	}?>
<?php endforeach;?>
<?php if(count($scene_times) > 4):?><li class="arrow next"></li><?php endif; ?>
</ul>