<div class="likes">
    <div class="rep-like">
        <div class="amount">
            <div class="arrow"></div>
            <?php echo $repins_count?>
        </div>
        <div class="info">
            <?php if(!ScenePeer::isRepinnedSceneByUser($origin_scene_id, $user->getId())) : ?>
                <?php echo link_to(image_tag("/images/repin.jpg", array('width' => '60', 'height' => '29')), array('sf_route' => 'scene_repin', 'scene_id' => $origin_scene_id), array('id' => 'new_repin')); ?>
            <?php else :?>
                <?php echo link_to(image_tag("/images/repin.jpg", array('width' => '60', 'height' => '29')), array('sf_route' => 'scene_unrepin', 'scene_id' => $origin_scene_id), array('id' => 'un_repin')); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="rep-like">
        <!--
        <div class="amount">
            <div class="arrow"></div>
            <?php echo $likes_count?>
        </div>
        -->
        <div class="info">
            <fb:like send="false" layout="box_count" width="60" height="29" show_faces="true"></fb:like>
            <!-- <a href="#"><img src="images/likes-2.jpg" alt="" width="60" height="29"></a> -->
        </div>
    </div>
</div>

<div id="fb-root"></div>

<script>
	<?php if($user->getId()):?>
		fbHooks(<?php echo sprintf('%d, %d', $scene_id, $user->getId()) ?>, "<?php echo url_for('@scene_change_liked_state'); ?>");
        repinClip();
    <?php endif;?>
</script>

<!--
<?php slot('repin_modal') ?>
<div id='new_repin_modal' style="display: none;" class="pop-window">
	<form method="post" action="<?php echo url_for('scene_repin');?>">
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
						<?php echo $form['board_id']?>
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

-->