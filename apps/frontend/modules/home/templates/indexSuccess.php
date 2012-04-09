<?php slot('homepage_filter')?>
<?php include_component('home', 'filterForm', array('current_user' => $user, 'source' => $source, 'categories' => $categories,
	'welcome_close' => $welcome_close, 'error' => $error, 'search_string' => $search_string,
	'sf_cache_key' => $user->getId().$source.md5(serialize($categories)).($welcome_close ? '1' : '0').$error.md5($search_string)))?>
<?php end_slot()?>
<div class="video-stickers">
	<ul id="container" class="stickers-list" style="position: relative;">
		<?php include_component('home', 'clipList', array('criteria' => $criteria, 'next_url' => $next_url, 'page' => $page, 'current_user' => $user, 'source' => $source, 'sf_cache_key' => $user->getId().$page.md5($criteria->toString())))?>
	</ul>
	<script type="text/javascript">
		_kmq.push(['record', 'Viewed Homepage']);
		<?php if($new_user):?>
		_kmq.push(['record', 'Signed Up']);
		<?php endif;?>
		layoutAndScroll('<?php echo $next_url ?>');
	</script>
</div>

<?php include_partial('home/modalScene', array('current_user' => $user, 'current_url' => $current_url, 'post_facebook' => $post_facebook));?>

<?php if ($modal): ?>
<script type="text/javascript">
	$(function(){
		stickerClick('<?php echo $board_id?>', '<?php echo url_for('scene_change', array('scene_id' => $scene_id, 'modal' => 1)) ?>', '<?php echo $current_url ?>', '<?php echo url_for('scene_change', array('scene_id' => $scene_id, 'modal' => 1)) ?>', 0, '<?php echo $scene_id ?>');
	});
</script>
<?php endif ?>