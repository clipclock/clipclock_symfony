<?php include_component('home', 'filterForm', array('current_user' => $user, 'form' => $form, 'welcome_close' => $welcome_close, 'error' => $error))?>
<div class="video-stickers">
	<ul id="container" class="stickers-list" style="position: relative;">
		<?php include_component('home', 'clipList', array('pager' => $pager, 'current_user' => $user, 'source' => $source, 'category' => $category))?>
	</ul>
	<script type="text/javascript">
		layoutAndScroll('<?php echo url_for('homepage_page', array('page' => $pager->getNextPage(), 'source' => $source, 'category' => $category)) ?>');
	</script>
</div>