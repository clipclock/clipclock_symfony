<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('reclip_id' => $clip_id['reclip_id'], 'current_user' => $current_user))?>
<?php endforeach?>
<?php if($pager->getNextPage() != $pager->getPage()):?>
<div class="pager_navigation">
	<a href="<?php echo url_for('board_page', array('id' => $current_board->getId(), 'username_slug' => $current_user->getNick(), 'page' => $pager->getNextPage())) ?>"><?php echo $pager->getNext();?></a>
</div>
<?php endif;?>