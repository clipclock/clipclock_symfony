<?php foreach($clips_ids as $clip_id):?>
	<?php include_component('board', 'clipSticker', array('reclip_id' => $clip_id['reclip_id'], 'filter_scene_id' => $clip_id['scene_id'], 'current_user' => $current_user))?>
<?php endforeach?>
<?php include_partial('static/loadingMsg')?>
<?php if($pager->getNextPage() != $pager->getPage()):?>
<div class="pager_navigation">
	<a href="<?php echo url_for('my_comments_page', array('nick' => $user->getNick(), 'page' => $pager->getNextPage())) ?>"><?php echo $pager->getNext();?></a>
</div>
<?php endif;?>