<?php include_component('home', 'filterForm', array('current_user' => $user, 'form' => $form, 'welcome_close' => $welcome_close, 'error' => $error))?>
<div class="video-stickers">
	<ul id="container" class="stickers-list" style="position: relative;">
		<?php include_component('home', 'clipList', array('pager' => $pager, 'current_user' => $user, 'source' => $source, 'category' => $category))?>
	</ul>
	<script type="text/javascript">
		_kmq.push(['record', 'Viewed Homepage']);
		<?php if($new_user):?>
		_kmq.push(['record', 'Signed Up']);
		<?php endif;?>
		layoutAndScroll('<?php echo url_for('homepage_page', array('page' => $pager->getNextPage(), 'source' => $source, 'category' => $category)) ?>');
	</script>
</div>
	<?php include_partial('home/modalScene', array('current_user' => $user, 'current_url' => $current_url));?>