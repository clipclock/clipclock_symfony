<div style="float: left; width: 150px;">
	<div id="people_sticker" style="width:150px;">
		<?php include_component('scene', 'peopleForSceneSticker', array('scene_id' => $current_scene->getId()))?>
	</div>
</div>
<div style="float: left; width: 700px;">
	<?php include_component('scene', 'sceneView', array('scene' => $current_scene))?>
</div>
<div style="float: left; width: 150px;">
	<div id="fun_buttons">
		<?php include_component('scene', 'sceneViewSocialButtons', array('scene_id' => $current_scene->getId()))?>
	</div>
</div>
