<div class="likes">
	<?php if($user->getId() && $user->getId() != $current_user->getId()):?>
    <div class="rep-like">
        <div class="amount">
            <div class="arrow"></div>
            <?php echo $repins_count?>
        </div>
        <div class="info">
            <?php if(!ScenePeer::isRepinnedSceneByUser($origin_scene_id, $current_user->getId())) : ?>
                <?php echo link_to(image_tag("/images/repin.jpg", array('width' => '60', 'height' => '29')), array('sf_route' => 'scene_repin', 'scene_id' => $origin_scene_id), array('id' => 'new_repin')); ?>
            <?php else :?>
                <?php echo link_to(image_tag("/images/repin.jpg", array('width' => '60', 'height' => '29')), array('sf_route' => 'scene_unrepin', 'scene_id' => $origin_scene_id), array('id' => 'un_repin')); ?>
            <?php endif; ?>
        </div>
    </div>
	<?php slot('repin_modal') ?>
		<?php include_partial('scene/modalForm', array('form' => $repin_form, 'form_url' => url_for('scene_repin'), 'form_partial' => 'scene/repinFormFields', 'id' => 'new_repin_modal'))?>
	<?php end_slot(); ?>
	<?php endif; ?>
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
		fbHooks(<?php echo sprintf('%d, %d', $scene_id, $current_user->getId()) ?>, "<?php echo url_for('@scene_change_liked_state'); ?>");
        repinClip();
    <?php endif;?>
</script>
