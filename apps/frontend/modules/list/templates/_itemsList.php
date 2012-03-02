<?php foreach($results as $result):?>
	<?php include_component('list', 'item', array('user_id' => $result['user_id'], 'current_user' => $current_user))?>
<?php endforeach?>
<?php if($pager->getNextPage() != $pager->getPage()):?>
<div class="pager_navigation">
	<a href="<?php echo url_for('homepage_page', array('page' => $pager->getNextPage(), 'source' => $source, 'category' => $category)) ?>"><?php echo $pager->getNext();?></a>
</div>
<?php endif;?>