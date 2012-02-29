<ul id="container" class="stickers-list" style="position: relative;">
<?php foreach($results as $result):?>
	<?php include_component('board', 'clipSticker', array('clip_id' => $result['clip_id'], 'current_user' => $current_user))?>
<?php endforeach?>
</ul>
<script type="text/javascript">
	$('.clip_sticker').wookmark({
		container: $('#container'),
		offset: 5,
		itemWidth: 235,
		autoResize: true
	});
</script>