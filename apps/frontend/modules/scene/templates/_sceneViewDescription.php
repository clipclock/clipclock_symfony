<div class="inside">
<?php foreach($scene_times as $scene_time):?>
<div id="scene_description_<?php echo $scene_time['id']?>" class="scene_description"<?php echo $scene_time['id'] != $scene_id ? 'style="display: none"' : '';?>>
	<div class="ph">
		<a href="<?php echo url_for('user', array('nick' => $scene_time['nick']))?>"><img src="<?php echo ImagePreview::c14n($scene_time['user_id'], 'medium', 'avatar');?>" alt="" width="50" height="50" /></a>
	</div>
	<div style="float: right">
		<img src="<?php echo ImagePreview::c14n($scene_time['clip_id'].$scene_time['scene_time']);?>" alt="" width="50" height="50" />
	</div>
	<p>
		<span class="t-bl"><a href="<?php echo url_for('user', array('nick' => $scene_time['nick']))?>"><?php echo $scene_time['first_name'] . ' ' . $scene_time['last_name']?></a>, Clipped 2 hours ago from <strong>YouTube</strong></span>
		<?php echo $scene_time['text']?>
	</p>
</div>
<?php endforeach;?>
</div>