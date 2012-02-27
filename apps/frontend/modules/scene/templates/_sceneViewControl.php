<?php slot('scene_modal') ?>
<?php include_partial('scene/modalForm', array('form' => $form, 'form_url' => url_for('scene_post'), 'form_partial' => 'scene/modalFormFields'))?>
<?php end_slot(); ?>

<a href="" class="arrows prev"></a>
<a href="" class="arrows next"></a>
<ul id="scene_controls" class="tabs">
<?php foreach($scene_times as $scene_time):?>
	<li id="scene_<?php echo $scene_time['id']?>"<?php if($scene_time['id'] == $scene_id):?> class="active"<?php endif;?>>
			<?php echo jq_link_to_remote(date('i:s', mktime(0, 0, $scene_time['scene_time'])), array(
				'update' => array('success_callback' => 'sceneChange(data); FB.XFBML.parse();', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
				'url'    => '@scene_change?scene_id='.$scene_time['id'],
				'method' => 'GET',
				'condition' => 'checkCurrentScene('.$scene_time['id'].', "'.$scene_time['scene_time'].'")',
			))?>
	</li>
<?php endforeach;?>
	<li id="new_time_scene" class="new-tag">New scene</li>
</ul>
