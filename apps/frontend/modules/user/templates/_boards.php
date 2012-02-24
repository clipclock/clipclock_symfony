<ul id="container" class="follow-set" style="position: relative;">
<?php foreach($boards as $board):?>
	<?php include_component('board', 'boardSticker', array('board_id' => $board->getId(), 'user' => $user))?>
<?php endforeach?>
</ul>
<script type="text/javascript">
	$('.board_sticker').wookmark({
		container: $('#container'),
		offset: 5,
		itemWidth: 235,
		autoResize: true
	});
</script>