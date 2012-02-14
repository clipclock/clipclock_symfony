<?php if(!$sf_user->isAuthenticated()):?>
	<?php echo link_to('Connect to facebook', '@connect_fb') ?>
<?php else:?>
	Welcome back, <?php echo $sf_user->getNick();?>
	<?php echo link_to('Logout', '@sf_guard_signout') ?><br />
<?php endif; ?>