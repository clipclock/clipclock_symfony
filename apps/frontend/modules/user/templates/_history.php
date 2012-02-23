<?php if(count($events)):?>
	<ul class="followers-events">
	<?php foreach($events as $event):?>
		<li>
			<div class="ph"><a href="<?php echo url_for('user', $user)?>"><img src="<?php echo ImagePreview::c14n($user, 'small', 'avatar');?>" alt="<?php echo $user?>" width="30" height="30" /></a></div>
			<p>
			<?php switch($event->getEventType()):case HistoryPeer::EVENT_NEW_SCENE:?>
				<a href="<?php echo url_for('user', $user)?>"><?php echo $user?></a> pinned <strong><a href="#"><?php echo $event->getScene()?></a> to <a href="#"><?php $event->getBoard()?></a></strong>
				<?php break;?>
			<?php endswitch?>
				<span class="how-long"><?php echo $event->getCreatedAt()?></span>
			</p>
		</li>
	<?php endforeach?>
	</ul>
<?php endif;?>