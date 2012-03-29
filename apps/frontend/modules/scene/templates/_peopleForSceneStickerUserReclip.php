<li>
	<div class="user-pic"><a href="<?php echo url_for('user', $user)?>"><img src="<?php echo ImagePreview::c14n($user->getId(), 'medium', 'avatar');?>" alt="<?php echo $user->getFullName()?>" title="<?php echo $user->getFullName()?>" /></a></div>
	<a href="<?php echo url_for('user', $user)?>"><strong><?php echo $user->getFullName()?></strong></a>
	<div class="txt">onto <a href="<?php echo url_for('board', array('id' => $scene->getBoardId(), 'username_slug' => $user->getNick()))?>"><strong><?php echo $board_name?></strong></a></div>
</li>