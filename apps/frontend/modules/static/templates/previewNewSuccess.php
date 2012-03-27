<script type="text/javascript">
	_kmq.push(['record', 'Upload new video']);
</script>
<div class="content-wrap-in">
	<div class="long-col">
		<div class="long-col-inside">
			<div class="center-col">
				<div class="b-main-video">
					<h2><?php echo $clip_name?></h2>
					<div class="viewing">
						<div id="scene_embed_video">
							<img src="/images/video.jpg" alt="" width="533" height="330" />
						</div>
					</div>
					<script type="text/javascript">
						embedClip(0, '<?php echo $clip_url?>', '<?php echo $source_name?>');
					</script>

					<?php slot('scene_modal') ?>
					<?php include_partial('scene/modalForm', array('form' => $form, 'form_url' => url_for('scene_post'), 'form_partial' => 'scene/modalFormFields'))?>
					<?php end_slot()?>
					<div class="b-tabs">

						<ul class="tabs-items">
							<li id='scene_add_comment' class="tag-new-cont" style="display: block">
								<!-- b-add-comment  -->
								<div class="b-add-comment">
									<div class="inside">
										<div class="ph">
											<a href="<?php echo url_for('user', $sf_user)?>"><img src="<?php echo ImagePreview::c14n($sf_user->getId(), 'medium', 'avatar');?>" alt="<?php echo $user?>" title="<?php echo $user?>" width="50" height="50" /></a>
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
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$().ready(function(){
		jQuery(".cusel").each(
				function(){
					var w = parseInt(jQuery(this).width()),
							scrollPanel = jQuery(this).find(".cusel-scroll-pane");
					if(w>=scrollPanel.width())
					{
						jQuery(this).find(".jScrollPaneContainer").width(w);
						scrollPanel.width(w);
					}
				});

		var params = {
			changedEl: ".line-form select",
			visRows: 4,
			scrollArrows: true
		}
		cuSel(params);
	});
</script>