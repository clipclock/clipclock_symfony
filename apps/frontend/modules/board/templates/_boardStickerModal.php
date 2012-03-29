	<div class="title">
		<h2><strong><a href="<?php echo url_for('board', array('id' => $board->getId(), 'username_slug' => $user->getNick()))?>"><?php echo $board->getName()?></a></strong></h2>
		<div class="b-btn">
			<?php if($current_user->getId()):?>
			<?php include_component('user', 'follow', array(
				'state_names' => array('Follow Channel', 'Unfollow Channel', 'Edit'),
				'sf_routes' => array('follow_board', 'unfollow_board', 'edit_board'),
				'id_key' => 'board_id',
				'id' => $board->getId(),
				'board_view' => false,
				'active' => $current_user->getId() == $user->getId() ? 'my' : BoardFollowerPeer::isBoardFollowedByUser($board->getId(), $current_user->getId())
			))?>
			<?php endif?>
		</div>
	</div>
	<ul class="list">
		<?php $count = count($clips_ids);
		foreach($clips_ids as $key => $clip_id):?>
		<?php include_component('board', 'boardStickerSceneTimePreview', array(
			'clip_id' => $clip_id['clip_id'],
			'board' => $board,
			'last' => count($clips_ids) >= 8 && $count == 1 ? true : false));$count--;?>
		<?php endforeach?>
		<?php if(count($clips_ids) >= 8):?><li class="transition"></li><?php endif;?>
	</ul>