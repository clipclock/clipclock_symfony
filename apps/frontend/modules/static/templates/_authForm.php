<?php if(!$user->getId()):?>
<ul class="autorizing">
	<li class="login"><a href="<?php echo url_for('connect_fb')?>">Login</a></li>
	<li class="about">
		<a href="">About</a>
		<div class="sub">
			<ul>
				<li><a href="">Help</a></li>
				<li class="before-divider"><a href="">Copyright</a></li>
				<li class="divider"><a href="">Careers</a></li>
				<li><a href="">Team</a></li>
				<li><a href="">Blog</a></li>
			</ul>
		</div>
	</li>
</ul>
<?php else: ?>
<ul class="autorized">
	<li class="invite"><a id="fb_invite" href="#">Invite</a></li>
	<li class="user">
		<a href="<?php echo url_for('user', $user)?>"><span><img src="<?php echo $user_image?>" alt="" width="21" height="21" /></span><strong><?php echo $user->getFirstName()?></strong></a>
		<div class="sub">
			<ul>
				<li><a href="<?php echo url_for('my_boards', $user)?>">Channels</a></li>
				<li><a href="<?php echo url_for('my_pins', $user)?>">Clips</a></li>
				<li class="before-divider"><a href="<?php echo url_for('my_likes', $user)?>">Likes</a></li>
				<li class="divider"><a href="<?php echo url_for('sf_guard_signout')?>">Logout</a></li>
			</ul>
		</div>
	</li>
	<li class="about">
		<a href="">About</a>
		<div class="sub">
			<ul>
				<li><a href="">Copyright</a></li>
				<li><a href="">Blog</a></li>
			</ul>
		</div>
	</li>
</ul>
<script type="text/javascript">
	fbHooks(<?php echo $fb_app_id?>);
</script>
<?php endif;?>