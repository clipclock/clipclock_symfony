<?php if($boards):?>
	<p>Your boards:</p>
	<?php foreach($boards as $board): ?><?php echo url_for('board', $board)?>
		<a href="<?php echo url_for('board', $board)?>"><?php echo $board->getName()?></a><br />
	<?php endforeach; ?>
<?php endif;?>