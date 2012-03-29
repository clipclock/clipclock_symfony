<?php slot('clip_modal') ?>

<?php if($current_user->getId()):?>
	<?php slot('scene_modal') ?>
		<?php include_partial('scene/modalForm', array('exists' => true, 'form_url' => url_for('scene_post'), 'form_partial' => 'scene/modalFormFields'))?>
	<?php end_slot(); ?>
<?php endif?>
<script type="text/javascript">
	closeModalScene();
</script>
<div id="clip_modal" class="modal-window" style="display: none;">
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
				<div class="scence-autor">
					<div id="owner_avatar" class="user-pic"></div>
					<div id='owner_text' class="name">
						<!--div class="date">Upload 5 days ago</div-->
					</div>
					<div id="owner_button" class="b-btn">
					</div>
				</div>
				<!-- /scence-autor -->
				<div id="clip_embed">
					<h2>&nbsp;</h2>
					<div class="viewing">
						<div id="scene_embed_video">
							<span></span>
						</div>
					</div>
				</div>
				<!-- b-tabs  -->
				<div class="b-tabs">

					<div id="clip_controls">
					</div>
					<ul class="tabs-items">
						<?php if($current_user->getId()):?>
						<li id='scene_add_comment' class="tag-new-cont">
							<?php include_partial('scene/sceneViewNewSceneForm', array('current_user' => $current_user))?>
						</li>
						<?php endif?>
						<li class="active ajax_toogle_container">
							<!-- b-autor-text  -->
							<div id="description" class="b-autor-text">
								<div class="inside">
								</div>
							</div>

							<div class="ajax_toogle">
								<!-- /b-autor-text -->
								<?php if($current_user->getId()):?>
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
<?php end_slot()?>