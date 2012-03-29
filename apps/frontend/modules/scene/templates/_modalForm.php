<div id='<?php echo (isset($id)) ? $id : 'new_time_scene_modal' ; ?>' style="display: none;" class="pop-window">
	<form class="new_clip" id="<?php echo (isset($exists)) ? 'new_clip_exists_video' : 'new_clip_new_video' ; ?>" method="post" action="<?php echo $form_url;?>">
		<div class="close"></div>
		<!-- b-header  -->
		<div class="b-header">
			<h2>Add a clip <span id="label_time">01:32</span> in the channel</h2>
		</div>
		<!-- /b-header -->
		<!-- b-content  -->
		<div class="b-content">
			<div class="add-video-scene">
				<!-- video-descriptions  -->
				<div class="video-descriptions">
					<div class="modal_form line-form">
						<?php include_partial($form_partial, array('form' => $form))?>
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