<div class="b-content">
<div class="content-wrap-in">
	<!-- side-left-col  -->
	<div class="side-left-col">
		<!-- follow-user  -->
		<div class="follow-user">
			<?php include_component('user', 'info', array('user' => $user)) ?>
			<?php include_component('user', 'followersList', array('user' => $user)) ?>
			<?php include_component('user', 'history', array('user' => $user)) ?>
		</div>
	</div>
	<div class="long-col">
		<?php include_component('user', 'boards', array('user' => $user, 'current_user' => $current_user)) ?>
	</div>
</div>
</div>