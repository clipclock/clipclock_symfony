
		<!-- b-user-list  -->
		<div class="b-user-list round-b-default">
			<!-- title  -->
			<div class="title">
				<div class="back"><a href="<?php echo $back_url ? $back_url : url_for('homepage')?>">Back</a></div>
				<div class="event"><?php echo $object?> <?php echo $type?></div>
			</div>
			<!-- /title -->
			<!-- list  -->
			<div class="list">
				<ul id="container">
					<?php include_component('list', 'itemsList', array('pager' => $pager, 'user' => $user)) ?>
				</ul>
			</div>
		</div>
