<div class="video-stickers">
	<ul id="container" class="stickers-list" style="position: relative;">
<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('clip_id' => $clip_id['clip_id'], 'board_id' => $board->getId()))?>
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
</div>