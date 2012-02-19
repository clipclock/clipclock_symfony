<?php foreach($scene_times as $scene_time):?>
	<span id="scene_<?php echo $scene_time['id']?>"<?php if($scene_time['id'] == $scene_id):?> class="active"<?php endif;?>>
			<?php echo jq_link_to_remote(date('i:s', mktime(0, 0, $scene_time['scene_time'])), array(
				'update' => array('success_callback' => 'sceneChange(data); FB.XFBML.parse();', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
				'url'    => '@scene_change?scene_id='.$scene_time['id'],
				'method' => 'GET',
				'condition' => 'checkCurrentScene('.$scene_time['id'].', "'.$scene_time['scene_time'].'")',
			))?>
	</span>
<?php endforeach;?>
<a href="#" id="new_time_scene">New scene</a><br />
<div id='new_time_scene_description_container' style="display: none;">
	<span id="new_time_scene_time" style="display: none;"></span>
	<textarea id="new_time_scene_description" rows="5" cols="20"></textarea>
	<a href="#" id="new_time_scene_description_container_submit">Create scene</a>
</div>
<div id='new_time_scene_modal' style="display: none;">
	<form method="post" action="<?php echo url_for('scene_post');?>">
		<?php echo $form?>
		<input type="submit" />
	</form>
</div>
