<li>
	<div class="inner">
		<h4><a href="<?php echo url_for('board', $board)?>"><?php echo $board->getName()?></a></h4>
		<div class="follow-videos">
			<ul>
				<?php foreach($scenes as $scene):?>
					<li><a href="#"><img src='<?php echo $scenes_images[$scene->getId()]?>' alt=''></a></li>
				<?php endforeach?>
			</ul>
		</div>
		<div class="b-btn">
			<a href="" class="default-un-follow-btn">Follow Set</a>
			<a href="" class="default-un-follow-btn hidden">Unfollow Set</a>
		</div>
	</div>
</li>