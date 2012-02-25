<div class="b-content">
<div class="user-title">
    <!-- user-like  -->
    <div class="user-like">
        <!-- ph  -->
        <div class="ph">
            <?php echo link_to(image_tag($avatar_img), array('sf_route' => 'user', 'nick' => $nick)); ?>
        </div>
        <!-- /ph -->
        <!-- path  -->
        <div class="path">
            <?php echo buildNavigationPath($current_scene); ?>
        </div>
        <!-- /path -->
        <!-- b-btn  -->
        <?php include_component('user', 'follow', array(
                                'state_names' => array('Follow Video', 'Unfollow Video'),
                                'sf_routes' => array('follow_clip', 'unfollow_clip'),
                                'id_key' => 'clip_id',
                                'id' => $current_scene->getSceneTime()->getClipId(),
                                'active' => ClipFollowerPeer::isClipFollowedByUser($current_scene->getSceneTime()->getClipId(), $current_user->getId())
        ))?>


        <!-- /b-btn -->
    </div>
    <!-- /user-like -->
</div>