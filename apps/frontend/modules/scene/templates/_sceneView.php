<?php include_component('scene', 'sceneViewEmbed', array('scene_time_id' => $scene_time->getId()))?><hr />
<?php include_component('scene', 'sceneViewControl', array('board_id' => $scene->getBoardId(), 'clip_id' => $clip->getId(), 'scene_id' => $scene->getId()))?><hr />
<div id="description">
	<?php include_component('scene', 'sceneViewDescription', array('scene_id' => $scene->getId()))?>
</div>
<div id="comment_form">
	<?php include_component('scene', 'sceneViewCommentForm', array('scene_time_id' => $scene->getSceneTimeId()))?>
</div>
<div id="comments">
	<?php include_component('scene', 'sceneViewComments', array('scene_time_id' => $scene->getSceneTimeId()))?>
</div>