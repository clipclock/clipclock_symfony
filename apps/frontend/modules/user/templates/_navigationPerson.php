<?php slot('nav_bar') ?>
<div class="user-title">
    <!-- user-like  -->
    <div class="person">
        <!-- ph  -->
        <div class="ph">
            <?php echo link_to(image_tag($avatar_img), array('sf_route' => 'user', 'nick' => $nick)); ?>
        </div>
        <!-- /ph -->
        <!-- name-and-adress  -->
        <div class="name">
            <?php echo link_to($fullname, array('sf_route' => 'user', 'nick' => $nick)); ?>
        </div>
        <!-- /name-and-adress -->
        <!-- user-title-menu  -->
        <?php echo buildNavigationPath($sf_data->getRaw('subject'), $active); ?>
        <!-- /user-title-menu -->
        <!-- b-btn  -->
        <?php echo $sf_data->getRaw('follow_button'); ?>


        <!-- /b-btn -->
    </div>
    <!-- /user-like -->
</div>
<?php end_slot()?>