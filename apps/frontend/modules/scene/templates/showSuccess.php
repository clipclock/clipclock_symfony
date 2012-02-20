<div class="content-wrap-in">
	<div class="side-left-col">
		<ul class="follow-set">
			<?php include_component('board', 'boardSticker', array('board_id' => $current_scene->getBoardId(), 'user' => $user))?>
		</ul>
		<?php include_component('scene', 'peopleForSceneSticker', array('scene_id' => $current_scene->getId()))?>
	</div>
	<div class="long-col">
		<div class="long-col-inside">
			<div class="right-mini-coll">
				<?php //include_component('scene', 'sceneViewSocialButtons', array('scene_id' => $current_scene->getId()))?>
			</div>
			<div class="center-col">
				<div class="b-main-video">
					<?php include_component('scene', 'sceneView', array('scene' => $current_scene))?>
				</div>
			</div>
		</div>
	</div>
</div>