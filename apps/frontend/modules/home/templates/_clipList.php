<?php foreach($results as $result):?>
	<?php include_component('board', 'clipSticker', array('reclip_id' => $result['reclip_id'], 'current_user' => $current_user))?>
<?php endforeach?>
<?php if($pager->getNextPage() != $pager->getPage()):?>
<?php include_partial('static/loadingMsg')?>
<div class="pager_navigation">
	<a href="<?php echo url_for('homepage_page', array('page' => $pager->getNextPage(), 'source' => $source, 'category' => $category)) ?>"><?php echo $pager->getNext();?></a>
</div>
<?php endif;?>