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
		<div class="b-btn">
			<a href="" class="default-un-follow-btn">Follow Set</a>
			<a href="" class="default-un-follow-btn hidden">Unfollow Set</a>
		</div>
	</div>
</li>