<?php slot('homepage_filter')?>
<?php include_component('home', 'filterForm', array('current_user' => $user, 'source' => $source, 'categories' => $categories,
	'welcome_close' => $welcome_close, 'error' => $error, 'search_string' => $search_string,
	'sf_cache_key' => $user->getId().$source.md5(serialize($categories)).($welcome_close ? '1' : '0').$error.md5($search_string)))?>
<?php end_slot()?>
<div class="video-stickers">
	<ul id="container" class="stickers-list" style="position: relative;">
		<?php include_component('home', 'clipList', array('criteria' => $criteria, 'next_url' => $next_url, 'page' => $page, 'current_user' => $user, 'source' => $source, 'sf_cache_key' => $user->getId().$page.md5($criteria->toString())))?>
	</ul>
</div>

<?php include_partial('home/modalScene', array('current_user' => $user, 'current_url' => isset($bug_current_url) ? $bug_current_url : $current_url , 'post_facebook' => $post_facebook));?>

<script type="text/javascript">

$(function(){
	_kmq.push(['record', 'Viewed Homepage']);
	layoutAndScroll('<?php echo $next_url ?>');
<?php if ($modal): ?>
	if ($.browser.msie){
		<?php if (isset($scene_id)): ?>
		window.location.href = "<?php echo url_for('redirect_to_scene', array('scene_id' => $scene_id)) ?>";
		<?php endif ?>
	} else {
		stickerClick(0, '<?php echo url_for('scene_change', array('scene_id' => $scene_id, 'modal' => 1)) ?>', '<?php echo $current_url ?>', '<?php echo url_for('scene_change', array('scene_id' => $scene_id, 'modal' => 1)) ?>', 0, '<?php echo $scene_id ?>', '<?php echo $new_user?>');
	}
	<?php elseif($new_user && $user->getId()): ?>
			categoryMultiSelectorModalToggle();
<?php endif ?>

<?php if($new_user && $user->getId()): ?>
	_kmq.push(['record', 'Signed Up']);
<?php endif ?>
});
</script>