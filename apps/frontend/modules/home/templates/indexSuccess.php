<?php include_component('home', 'filterForm', array('current_user' => $user, 'form' => $form))?>
<div class="video-stickers">
	<?php include_component('home', 'clipList', array('pager' => $pager, 'current_user' => $user))?>
</div>