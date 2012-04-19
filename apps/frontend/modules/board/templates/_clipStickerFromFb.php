<?php if(!$reclip_id):?>
<li class="clip_sticker">
	<div class="inner">
		<p class="name-of-scence"><?php echo $clip_key?></p>
	</div>
</li>
<?php elseif(!$friended_video):?>
	<?php include_component('board', 'clipSticker', array('current_user' => $current_user, 'reclip_id' => $reclip_id))?>
<?php endif;?>