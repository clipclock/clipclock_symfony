<?php slot('clip_modal') ?>

<?php if($current_user->getId()):?>
	<?php slot('scene_modal') ?>
		<?php include_partial('scene/modalForm', array('exists' => true, 'form_url' => url_for('scene_post'), 'form_partial' => 'scene/modalFormFields'))?>
	<?php end_slot(); ?>
<?php endif?>
<div class="clip_modal_fixed" style="display: none;">
	<div id="clip_modal" class="modal-window">
		<!--div class="arrows prev"><span></span></div>
	  <div class="arrows next"><span></span></div-->
		<!-- modal-wrap  -->
		<div class="modal-wrap">
			<div id="clip_modal_close" class="close"></div>
			<!-- right-mini-coll  -->
			<div class="right-mini-coll ajax_toogle_container">
				<div id="fun_buttons" class="ajax_toogle">
					<?php slot('repin_modal') ?>
					<?php include_partial('scene/modalForm', array('form' => null, 'form_url' => url_for('scene_repin'), 'form_partial' => 'scene/repinFormFields', 'id' => 'new_repin_modal'))?>
					<?php end_slot(); ?>
				</div>
			</div>
			<!-- /right-mini-coll -->
			<!-- center-col  -->
			<div class="center-col">
				<!-- b-main-video  -->
				<div class="b-main-video">
					<!-- scence-autor  -->
					<div class="ajax_toogle_container">
						<div class="scence-autor ajax_toogle">
							<div id="owner_avatar" class="user-pic"></div>
							<div id='owner_text' class="name">
								<!--div class="date">Upload 5 days ago</div-->
							</div>
							<div id="owner_button" class="b-btn">
							</div>
						</div>
					</div>
					<!-- /scence-autor -->
					<div id="clip_embed">
						<h2>&nbsp;</h2>

						<div class="viewing">
							<div id="scene_embed_video">
								<div id="scene_embed_video_player"><span></span></div>
							</div>
						</div>
					</div>
					<!-- b-tabs  -->
					<div class="b-tabs">

						<div id="clip_controls">
						</div>
						<ul class="tabs-items">
							<?php if($current_user->getId()): ?>
							<li id='scene_add_comment' class="tag-new-cont">
								<?php include_partial('scene/sceneViewNewSceneForm', array('current_user' => $current_user, 'post_facebook' => $post_facebook))?>
							</li>
							<?php endif?>
							<li id="scene_info" class="active ajax_toogle_container">
								<!-- b-autor-text  -->
								<div id="description" class="b-autor-text">
									<div class="inside">
									</div>
								</div>

								<div class="ajax_toogle">
									<!-- /b-autor-text -->
									<?php if($current_user->getId()): ?>
									<!-- b-add-comment  -->
									<div id="comment_form" class="b-add-comment">
										<div class="inside">
										</div>
									</div>
									<?php endif;?>
									<!-- /b-add-comment -->
									<!-- b-comment  -->
									<div id="comments"></div>
									<!-- /b-comment -->
									<!-- b-channel  -->
									<div id="channel" class="b-channel">

									</div>
									<!-- /b-channel -->
									<!-- b-people-likes  -->
									<div id="people_modal">

									</div>
								</div>
								<!-- /b-clip -->
							</li>
						</ul>
					</div>
					<!-- /b-tabs -->
				</div>
				<!-- /b-main-video -->
			</div>
			<!-- /center-col -->
		</div>
		<!-- /modal-wrap -->
	</div>
</div>
	<script type="text/javascript">

		newSceneTimeModalShow('scene_time_scene_time', 'scene_time_scene_text');

		$(function(){
			$('#clip_modal').click(function(e){
				e.stopPropagation();
			});

			$('#shadow, #clip_modal_close, .clip_modal_fixed').click(function(){
				toggleModalScene('<?php echo $current_url?>');
			});

			/*$(document).keyup(function(e) {
				if(e.which == 27 && $('#clip_modal:visible').length) {
					e.preventDefault();
					toggleModalScene('<?php echo $current_url?>');
				}
			});*/
		});

	</script>
<?php end_slot()?>