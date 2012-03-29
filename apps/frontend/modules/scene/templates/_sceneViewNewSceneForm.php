
	<!-- b-add-comment  -->
	<div class="b-add-comment">
		<div class="inside">
			<div class="ph">
				<a href="<?php echo url_for('user', $current_user)?>"><img src="<?php echo ImagePreview::c14n($current_user->getId(), 'medium', 'avatar');?>" alt="<?php echo $current_user->getFirstName()?>" title="<?php echo $current_user->getFirstName()?>" width="50" height="50" /></a>
			</div>
			<form method="get">
				<div class="brd">
					<span id="new_time_scene_time" style="display: none;"></span>
					<textarea id="new_time_scene_description" name="" cols="" rows=""></textarea>
				</div>
				<div class="b-btn">
					<input id="new_time_scene_description_container_submit" class="default-follow-btn" name="" type="button" value="Create clip" />
				</div>
			</form>
		</div>
	</div>
	<!-- /b-add-comment -->