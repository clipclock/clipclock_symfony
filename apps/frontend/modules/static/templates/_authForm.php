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
	<li class="invite"><a href="">Invite</a></li>
	<li class="user">
		<a href="<?php echo url_for('user', $user)?>"><span><img src="<?php echo $user_image?>" alt="" width="21" height="21" /></span><strong><?php echo $user->getNick()?></strong></a>
		<div class="sub">
			<ul>
				<li><a href="">Invite Friends</a></li>
				<li class="before-divider"><a href="">Find Friends</a></li>
				<li class="divider"><a href="">Boards</a></li>
				<li><a href="">Pins</a></li>
				<li class="before-divider"><a href="">Likes</a></li>
				<li class="divider"><a href="">Settings</a></li>
				<li><a href="<?php echo url_for('sf_guard_signout')?>">Logout</a></li>
			</ul>
		</div>
	</li>
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
<?php endif;?>