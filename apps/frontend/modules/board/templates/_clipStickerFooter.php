<ul class="management-sticker">
	<li class="fasted"><a href="<?php echo url_for('list_repins', array('username_slug' => $scene_info['nick'], 'board_id' => $scene_info['board_id'], 'id' => $scene_info['scene_id']))?>"><?php echo $repins_count?></a></li>
	<li class="repost"><a href="<?php echo url_for('list_comments', array('username_slug' => $scene_info['nick'], 'board_id' => $scene_info['board_id'], 'id' => $scene_info['scene_id']))?>"><?php echo $comments_count?></a></li>
	<li class="like"><a href="<?php echo url_for('list_likes', array('username_slug' => $scene_info['nick'], 'board_id' => $scene_info['board_id'], 'id' => $scene_info['scene_id']))?>"><?php echo $likes_count?></a></li>
</ul>