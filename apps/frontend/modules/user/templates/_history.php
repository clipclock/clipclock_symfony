<?php foreach($events as $event):?>
	<?php switch($event->getEventType()):case HistoryPeer::EVENT_NEW_SCENE:?>
		<?php echo $user?> pinned <?php echo $event->getScene()?> to <?php $event->getBoard()?><br />
		<?php echo $event->getCreatedAt()?>
		<?php break;?>
	<?php endswitch?>
	<hr />
<?php endforeach?>