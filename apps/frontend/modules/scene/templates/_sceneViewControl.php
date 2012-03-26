<?php if($current_user->getId()):?>
<?php slot('scene_modal') ?>
<?php include_partial('scene/modalForm', array('form' => $form, 'form_url' => url_for('scene_post'), 'form_partial' => 'scene/modalFormFields'))?>
<?php end_slot(); ?>
<?php endif?>
<ul id="scene_controls" class="tabs<?php if(count($scene_times) > 8):?> wide<?php endif;?>">
<?php if(count($scene_times) > 8):?><li class="arrow prev"></li><?php endif;?>
<?php $current_key = 0;foreach($scene_times as $key => $scene_time):?>
	<li id="scene_<?php echo $scene_time['id']?>"<?php if($scene_time['id'] == $scene_id): $current_key = $key;?> class="active"<?php endif;?>>
			<?php echo jq_link_to_remote(date('i:s', mktime(0, 0, $scene_time['scene_time'])), array(
				'update' => array('success_callback' => 'sceneChange(data, false, \''.url_for('scene', array('board_id' => $scene_time['board_id'], 'id' => $scene_time['id'], 'username_slug' => $scene_time['nick'])).'\', \''.url_for('@scene_change?scene_id='.$scene_time['id']).'\', \''.$scene_time['scene_time'].'\', \''.$scene_time['id'].'\'); FB.XFBML.parse();return false;', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
				'url'    => '@scene_change?scene_id='.$scene_time['id'],
				'method' => 'GET',
				'condition' => 'checkCurrentScene('.$scene_time['id'].', "'.$scene_time['scene_time'].'")',
			), array('href' => url_for('scene', array('board_id' => $scene_time['board_id'], 'id' => $scene_time['id'], 'username_slug' => $scene_time['nick']))))?>
	</li>
<?php endforeach;?>
<?php if($current_user->getId()):?>
	<li id="new_time_scene" class="new-tag">New clip</li>
<?php endif?>
	<?php if(count($scene_times) > 8):?><li class="arrow next"></li><?php endif;?>
</ul>
<script type="text/javascript">
	<?php $current_scene_time = $scene_times[$current_key];?>
		bindSceneChangeBack('<?php echo url_for('@scene_change?scene_id='.$current_scene_time['id'])?>', '<?php echo $current_scene_time['scene_time']?>', '<?php echo $current_scene_time['id']?>');
</script>