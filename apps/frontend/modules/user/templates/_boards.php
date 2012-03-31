<?php foreach($boards_ids as $board_id):?>
	<?php include_component('board', 'boardSticker', array('board_id' => $board_id['id'], 'user' => $user, 'current_user' => $current_user, 'sf_cache_key' => $board_id['id'].$current_user->getId()))?>
<?php endforeach?>
<?php include_partial('static/loadingMsg')?>
<?php if($pager->getNextPage() != $pager->getPage()):?>
<div class="pager_navigation">
	<a href="<?php echo url_for('my_boards_page', array('nick' => $user->getNick(), 'page' => $pager->getNextPage())) ?>"><?php echo $pager->getNext();?></a>
</div>
<?php endif;?>