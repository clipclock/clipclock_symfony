
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
            <?php echo buildNavigationPath($sf_data->getRaw('subject')); ?>
        </div>
        <!-- /path -->
        <!-- b-btn  -->
        <?php echo $sf_data->getRaw('follow_button'); ?>


        <!-- /b-btn -->
    </div>
    <!-- /user-like -->
</div>