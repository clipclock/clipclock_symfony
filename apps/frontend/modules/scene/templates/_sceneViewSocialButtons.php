<?php if($user->getId()):?>
<div class="likes">
	<div class="rep-like">
		<!--
        <div class="amount">
            <div class="arrow"></div>
            <?php echo $likes_count?>
        </div>
        -->
		<div class="info">
			<fb:like send="true" layout="box_count" width="60" height="29" show_faces="true"></fb:like>
			<!-- <a href="#"><img src="images/likes-2.jpg" alt="" width="60" height="29"></a> -->
		</div>
	</div>
</div>
<?php endif; ?>
<?php if($user->getId() && $user->getId() != $current_user->getId()):?>
<div class="likes">
    <div class="rep-like">
        <div class="amount">
            <div class="arrow"></div>
            <?php echo $repins_count?>
        </div>
        <div class="info">
            <?php if(!ScenePeer::isRepinnedSceneByUser($origin_scene_id, $current_user->getId())) : ?>
                <?php echo link_to('&nbsp;', array('sf_route' => 'scene_repin', 'scene_id' => $origin_scene_id), array('id' => 'new_repin')); ?>
            <?php else :?>
                <?php echo link_to('&nbsp;', array('sf_route' => 'scene_unrepin', 'scene_id' => $origin_scene_id), array('id' => 'un_repin')); ?>
            <?php endif; ?>
        </div>
    </div>
	<?php slot('repin_modal') ?>
		<?php include_partial('scene/modalForm', array('form' => $repin_form, 'form_url' => url_for('scene_repin'), 'form_partial' => 'scene/repinFormFields', 'id' => 'new_repin_modal'))?>
	<?php end_slot(); ?>
</div>
<?php endif; ?>

<div class="likes">
	<div class="rep-like">
		<div class="info">
			<div id="d_clip_container" style="position:relative">
				<a id="copy_link" href="javascript:return;">&nbsp;</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	<?php if($user->getId()):?>
		$().ready(function(){
			//fbHooks(<?php echo $fb_app_id?>, <?php echo sprintf('%d, %d', $scene_id, $current_user->getId()) ?>, "<?php echo url_for('@scene_change_liked_state'); ?>");
			asyncRequestor.call('facebook', function(){
				console.log(<?php echo $user->getId()?>);
				function toggleFBLikeButton(scene_id, user_id, state, url) {
					if(state)
					{
						_kmq.push(['record', 'Shared', {'share_type':'FB Like'}]);
					}
					$.ajax({
						url: url,
						type: "GET",
						data: { user_id : user_id, scene_id : scene_id, state: state }
					});
				}

				FB.Event.subscribe('edge.create',
						function(response) { toggleFBLikeButton(<?php echo $scene_id?>, <?php echo $current_user->getId()?>, 1, "<?php echo url_for('@scene_change_liked_state'); ?>"); }
				);

				FB.Event.subscribe('edge.remove',
						function(response) { toggleFBLikeButton(<?php echo $scene_id?>, <?php echo $current_user->getId()?>, 0, "<?php echo url_for('@scene_change_liked_state'); ?>"); }
				);
			});


			if(!$('#clip_modal').length){
				repinClip();
			}
		});
    <?php endif;?>
</script>
