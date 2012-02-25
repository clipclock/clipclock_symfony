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
<?php include_slot('repin_modal') ?>
<!-- ******************		HEAD START ****************************** -->
<div id="head">
	<!-- header  -->
	<div class="header">
		<a href="<?php echo url_for('homepage')?>" class="logo"></a>
		<!-- head-menu  -->
		<div class="head-menu">
			<?php include_component('static', 'authForm', array('user' => $sf_user))?>
		</div>
		<!-- /head-menu -->
		<!-- head-search  -->
		<?php include_component('static', 'clipForm', array('user' => $sf_user)) ?>
		<!-- /head-search -->
	</div>
	<?php include_slot('homepage_filter') ?>
	<!-- /header -->
</div>
<!-- ******************		HEADE END ******************************** -->

<!-- ******************		CONTENT START *************************** -->
<div id="content">
<div class="wrapper-auto-size">
	<?php echo $sf_content ?>
</div>
</div>
<!-- ******************		CONTENT END ***************************** -->

</div>
<!-- ****************** WRAPPER END ****************************** -->
</body>
</html>