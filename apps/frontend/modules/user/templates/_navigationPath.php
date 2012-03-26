<?php slot('nav_bar') ?>
<div class="user-title">
    <!-- user-like  -->
	<div class="person">
        <!-- ph  -->

        <div class="ph ajax_toogle_container">
			<div id="nav_avatar" class="ajax_toogle">
            <?php echo link_to(image_tag($avatar_img), array('sf_route' => 'user', 'nick' => $nick)); ?>
			</div>
        </div>
        <!-- /ph -->
		<div class="name">
        <!-- path  -->
        <div class="ajax_toogle_container">
			<div id="nav_path" class="ajax_toogle">
            <?php echo buildNavigationPath($sf_data->getRaw('subject')); ?>
			</div>
        </div>
		</div>
        <!-- /path -->
        <!-- b-btn  -->
        <?php echo $sf_data->getRaw('follow_button'); ?>


        <!-- /b-btn -->
    </div>
    <!-- /user-like -->
</div>
<?php end_slot()?>