<div class="inside">
<?php foreach($scene_times as $scene_time):?>
<div id="scene_description_<?php echo $scene_time['id']?>" class="scene_description"<?php echo $scene_time['id'] != $scene_id ? 'style="display: none"' : '';?>>

<div class="b-scence">
	<div class="prev-img">
		<img src="<?php echo ImagePreview::c14n($scene_time['clip_id'].$scene_time['scene_time']);?>" alt="" width="61" height="61" />
	</div>
	<span>
		<?php echo $scene_time['text']?>
	</span>
</div>

<div class="b-autor-t">
	<div class="ph">
		<a href="<?php echo url_for('user', array('nick' => $scene_time['nick']))?>"><img src="<?php echo ImagePreview::c14n($scene_time['user_id'], 'medium', 'avatar');?>" alt="" width="50" height="50" /></a>
	</div>
	<p>
		<span class="t-bl"><a href="<?php echo url_for('user', array('nick' => $scene_time['nick']))?>"><?php echo $scene_time['first_name'] . ' ' . $scene_time['last_name']?></a></span>
		<?php echo $scene_time['repined_nick'] ? ' via '.link_to($scene_time['repined_first_name'].' '.$scene_time['repined_last_name'], url_for('user', array('nick' => $scene_time['repined_nick']))) : ''?> <?php echo $scene_time['repined_nick'] ? 're' : ''?>clipped from <?php echo $scene_time['repined_board_id'] ? 'channel '.link_to($scene_time['repined_board_name'], url_for('board', array('username_slug' => $scene_time['repined_nick'], 'id' => $scene_time['repined_board_id']))) : '<strong>YouTube</strong>'?> about <?php echo time_ago($scene_time['created_at'], 1)?>
	</p>
</div>

</div>
<?php endforeach;?>
</div>