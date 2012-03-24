<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('reclip_id' => $clip_id['reclip_id'], 'current_user' => $current_user))?>
<?php endforeach?>
<?php include_partial('static/loadingMsg')?>
<?php if($pager->getNextPage() != $pager->getPage()):?>
<?php echo $pager->getNextPage().' '.$current_board->getId().' '.$user->getNick() ?>
<?php echo url_for('board_page', array('id' => $current_board->getId(), 'username_slug' => $user->getNick(), 'page' => $pager->getNextPage())) ?>"><?php echo $pager->getNext();?>
<div class="pager_navigation">
	<a href="<?php echo url_for('board_page', array('id' => $current_board->getId(), 'username_slug' => $user->getNick(), 'page' => $pager->getNextPage())) ?>"><?php echo $pager->getNext();?></a>
</div>
<?php endif;?>