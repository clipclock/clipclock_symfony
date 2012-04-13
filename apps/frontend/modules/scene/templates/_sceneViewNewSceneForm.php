
	<!-- b-add-comment  -->
	<div class="b-add-comment">
		<div class="inside">
			<div class="ph">
				<a href="<?php echo url_for('user', $current_user)?>"><img src="<?php echo ImagePreview::c14n($current_user->getId(), 'medium', 'avatar');?>" alt="<?php echo $current_user->getFirstName()?>" title="<?php echo $current_user->getFirstName()?>" width="50" height="50" /></a>
			</div>
			<form method="get">
				<div class="brd">
					<span id="new_time_scene_time" style="display: none;"></span>
					<textarea id="new_time_scene_description" defaultText='Pause the video at the moment you like, text what you liked in that moment, and click the "Create clip" button' name="" cols="" rows="">Pause the video at the moment you like, text what you liked in that moment, and click the "Create clip" button</textarea>
				</div>
				<div class="b-btn">
					<input style="float: left;" id="new_time_scene_description_container_submit" class="default-follow-btn" name="" type="button" value="Create clip" />
					<div id="facebook_checkbox" class="facebook_checkbox">
						<span>Post on Facebook</span><input name="" type="checkbox" class="default-un-follow-btn"<?php if($post_facebook):?> checked="checked"<?php endif;?> value="1" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /b-add-comment -->