<li class="board_sticker">
	<div class="inner">
		<h4><a href="<?php echo url_for('board', array('id' => $board->getId(), 'username_slug' => $user->getNick()))?>"><?php echo $board->getName()?></a></h4>
		<div class="follow-videos">
			<ul>
				<?php foreach($clips_ids as $clip_id):?>
					<?php include_component('board', 'boardStickerSceneTimePreview', array(
						'clip_id' => $clip_id['clip_id'],
						'board_id' => $board->getId()))?>
				<?php endforeach?>
			</ul>
		</div>
		    <?php include_component('user', 'follow', array(
                        'state_names' => array('Follow Set', 'Unfollow Set', 'Edit'),
                        'sf_routes' => array('follow_board', 'unfollow_board', 'edit_board'),
                        'id_key' => 'board_id',
                        'id' => $board->getId(),
                        'active' => $current_user->getId() == $user->getId() ? 'my' : BoardFollowerPeer::isBoardFollowedByUser($board->getId(), $current_user->getId())
              ))?>

	</div>
</li>
