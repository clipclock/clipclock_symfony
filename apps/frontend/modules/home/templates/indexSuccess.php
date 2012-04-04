<?php slot('homepage_filter') ?>
<?php include_component('home', 'filterForm', array('current_user' => $user, 'source' => $source, 'categories' => $categories,
	'welcome_close' => $welcome_close, 'error' => $error,
	'sf_cache_key' => $user->getId().$source.md5(serialize($categories)).($welcome_close ? '1' : '0').$error))?>
<?php end_slot()?>
<div class="video-stickers">
	<ul id="container" class="stickers-list" style="position: relative;">
		<?php include_component('home', 'clipList', array('criteria' => $criteria, 'page' => $page, 'current_user' => $user, 'source' => $source, 'sf_cache_key' => $user->getId().$page.md5($criteria->toString())))?>
	</ul>
	<script type="text/javascript">
		_kmq.push(['record', 'Viewed Homepage']);
		<?php if($new_user):?>
		_kmq.push(['record', 'Signed Up']);
		<?php endif;?>
		layoutAndScroll('<?php echo url_for('homepage_page', array('page' => ++$page)) ?>');
	</script>
</div>
	<?php include_partial('home/modalScene', array('current_user' => $user, 'current_url' => $current_url, 'post_facebook' => $post_facebook));?>