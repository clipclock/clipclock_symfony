<?php slot('scene_modal') ?>
<div id='new_time_scene_modal' style="display: none;" class="pop-window">
	<form method="post" action="<?php echo url_for('scene_post');?>">
	<div class="close"></div>
	<!-- b-header  -->
	<div class="b-header">
		<h2>Add a video scene 01:32 in the set</h2>
	</div>
	<!-- /b-header -->
	<!-- b-content  -->
	<div class="b-content">
		<div class="add-video-scene">
				<?php echo $form->renderHiddenFields()?>
				<!-- video-descriptions  -->
				<div class="video-descriptions">
					<div class="line-form">
						<?php echo $form['scene']['board_id']?>
					</div>
				</div>
				<!-- /video-descriptions -->

		</div>
	</div>
	<!-- /b-content -->
	<!-- b-footer  -->
	<div class="b-footer">
		<div class="b-btn">
			<input name="" type="reset" class="default-un-follow-btn" value="Cancel">
			<input name="" type="submit" class="default-follow-btn" value="Done">
		</div>
	</div>
	</form>
	<!-- /b-footer -->
</div>
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
