<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#" xml:lang="en" lang="en">
<head>
	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>
	<link rel="shortcut icon" href="/favicon.ico" />
	<?php include_stylesheets() ?>
	<?php include_javascripts() ?>
</head>
<body>
<div id="shadow" class="shadow" style="display: none;"></div>
<!-- ****************** WRAPPER START **************************** -->
<div id="wrapper">
<div class="scroll-to-top"></div>
<?php include_slot('scene_modal') ?>
<!-- ******************		HEAD START ****************************** -->
<div id="head">
	<!-- header  -->
	<div class="header">
		<a href="http://" class="logo"></a>
		<!-- head-menu  -->
		<div class="head-menu">
			<!-- autorizing  -->
			<ul class="autorizing hidden">
				<li class="sing"><a href="">Sign up</a></li>
				<li class="login"><a href="">Login</a></li>
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
			<!-- /autorizing -->
			<!-- autorized  -->
			<ul class="autorized">
				<li class="invite"><a href="">Invite</a></li>
				<li class="user">
					<a href=""><span><img src="/images/avatars/user-pic.jpg" alt="" width="21" height="21" /></span><strong>fdsfdklsjdfdffldksjfsd;flds;fkary</strong></a>
					<div class="sub">
						<ul>
							<li><a href="">Invite Friends</a></li>
							<li class="before-divider"><a href="">Find Friends</a></li>
							<li class="divider"><a href="">Boards</a></li>
							<li><a href="">Pins</a></li>
							<li class="before-divider"><a href="">Likes</a></li>
							<li class="divider"><a href="">Settings</a></li>
							<li><a href="">Loguot</a></li>
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
			<!-- /autorized -->
		</div>
		<!-- /head-menu -->
		<!-- head-search  -->
		<div class="head-search">
			<div class="inside">
				<div class="b-btn">
					<input name="" type="button" />
				</div>
				<div class="b-input">
					<input name="" type="text" title="Paste and enter YouTube video URL" value="Paste and enter YouTube video URL" />
				</div>
			</div>
		</div>
		<!-- /head-search -->
	</div>
	<!-- /header -->
</div>
<!-- ******************		HEADE END ******************************** -->




<!-- ******************		CONTENT START *************************** -->
<div id="content">
<div class="wrapper-auto-size">
	<div class="b-content">
	<?php echo $sf_content ?>
	</div>
</div>
</div>
<!-- ******************		CONTENT END ***************************** -->

</div>
<!-- ****************** WRAPPER END ****************************** -->
</body>
</html>