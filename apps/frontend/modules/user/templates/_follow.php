<div class="b-btn">
	<?php if($active != 'my'): ?>
    <?php echo link_to($state_names[0], array('sf_route' => $sf_routes[0], $id_key => $id), array('class' => sprintf('ajax-button default-follow-btn %s', ($active) ? 'hidden' : ''))); ?>
    <?php echo link_to($state_names[1], array('sf_route' => $sf_routes[1], $id_key => $id), array('class' => sprintf('ajax-button default-un-follow-btn %s', ($active) ? '' : 'hidden'))); ?>
	<?php else: ?>
	<?php echo link_to($state_names[2], array('sf_route' => $sf_routes[2], $id_key => $id), array('class' => 'ajax-button default-un-follow-btn')); ?>
	<?php endif;?>
</div>