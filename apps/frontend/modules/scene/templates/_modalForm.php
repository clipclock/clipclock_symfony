<div id='<?php echo (isset($id)) ? $id : 'new_time_scene_modal' ; ?>' style="display: none;" class="pop-window">
	<form method="post" action="<?php echo $form_url;?>">
		<div class="close"></div>
		<!-- b-header  -->
		<div class="b-header">
			<h2>Add a video scene <span id="human_time">01:32</span> in the set</h2>
		</div>
		<!-- /b-header -->
		<!-- b-content  -->
		<div class="b-content">
			<div class="add-video-scene">
				<?php echo $form->renderHiddenFields()?>
				<!-- video-descriptions  -->
				<div class="video-descriptions">
					<div class="line-form">
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
