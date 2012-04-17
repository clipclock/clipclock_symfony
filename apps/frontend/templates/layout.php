<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head prefix="og: http://ogp.me/ns# clipclock:
                  http://ogp.me/ns/apps/clipclock#">
	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>
	<link rel="shortcut icon" href="/favicon.ico" />
	<?php include_combined_stylesheets() ?>
	<?php include_combined_javascripts() ?>
</head>
<body>
<?php include_component('static', 'fbAppId', array('sf_cache_key' => 42))?>
<div id="fb-root"></div>
<script type="text/javascript">
	var _kmq = _kmq || [];
	function _kms(u){
		setTimeout(function(){
			var s = document.createElement('script'); var f = document.getElementsByTagName('script')[0]; s.type = 'text/javascript'; s.async = true;
			s.src = u; f.parentNode.insertBefore(s, f);
		}, 1);
	}
	_kms('//i.kissmetrics.com/i.js');_kms('//doug1izaerwt3.cloudfront.net/<?php echo sfConfig::get('app_kiss_key')?>.1.js');
</script>
<script type="text/javascript">var _kiq = _kiq || [];</script>
<script type="text/javascript" src="//s3.amazonaws.com/ki.js/33264/6tl.js" async="true"></script>
<div id="shadow" class="shadow" style="display: none;"></div>
<div id="shadow_interests" class="shadow" style="display: none;"></div>
<!-- ****************** WRAPPER START **************************** -->
<div id="wrapper">
<div id="scroll-to-top" class="scroll-to-top"></div>
<?php include_slot('scene_modal') ?>
<?php include_slot('repin_modal') ?>
<?php include_slot('clip_modal') ?>
<?php include_slot('category_modal') ?>
<!-- ******************		HEAD START ****************************** -->
<div id="head">
	<!-- header  -->
	<div class="header">
		<a href="<?php echo url_for('homepage')?>" class="logo"></a>
		<!-- head-menu  -->
		<div class="head-menu">
			<?php include_component('static', 'authForm', array('user' => $sf_user, 'sf_cache_key' => $sf_user->getId()))?>
		</div>
		<!-- /head-menu -->
		<!-- head-search  -->
		<?php include_component('static', 'clipForm', array('user' => $sf_user, 'sf_cache_key' => $sf_user->getId().$sf_user->getFlash('new_clip_form', ''))) ?>
		<!-- /head-search -->
	</div>
	<?php include_slot('homepage_filter') ?>
	<?php include_slot('nav_bar') ?>
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
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-30664522-1']);
	_gaq.push(['_setDomainName', 'clipclock.com']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
</body>
</html>