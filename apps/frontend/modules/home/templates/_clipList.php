<?php foreach($results as $result):?>
	<?php include_component('board', 'clipStickerLogic', array('reclip_id' => $result['reclip_id'], 'fb_user_id' => $result['fb_user_id'], 'fb_post_id' => $result['fb_post_id'], 'current_user' => $current_user, 'sf_cache_key' => $result['reclip_id'].$current_user->getId()))?>
<?php endforeach?>
<?php if($pager->getNextPage() != $pager->getPage()):?>
<?php include_partial('static/loadingMsg')?>
<div class="pager_navigation">
	<a href="<?php echo $next_url ?>"><?php echo $pager->getNext();?></a>
</div>
<?php endif;?>