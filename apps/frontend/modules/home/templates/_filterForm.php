<?php slot('homepage_filter') ?>
<?php if(!$welcome_close || $error):?>
<div class="welcome">
	<div class="close"></div>
	<div class="inner">
		<?php if(!$error):?>
		<h1>Are you new? We are glad to see you!</h1>
		<h2>Here you can comment and publish best moments of any YouTube video.<br />Copy and paste video URL, choose the right moments and create your clips!<!--a href="#">How does it work?</a--></h2>
		<?php else:?>
		<h1 class="invite">At the moment login is for invited persons only.</h1>
		<h2>You can watch the clips and comments, but to make and share your own clips please request an invitation from your friends already clipping with us.<br />Thank you!</h2>
		<?php endif;?>
	</div>
</div>
<?php endif; ?>
<!-- /welcome -->
<!-- b-filter  -->
<div class="b-filter">
	<form action="<?php echo url_for('homepage_bind')?>" method="post">
		<div class="col">
			<label>Show me</label>
			<div class="line-form">
				<?php echo $form['source']->render(array('class' => 'size164'))?>
			</div>
		</div>
		<div class="col">
			<label>Interest</label>
			<div class="line-form">
				<?php echo $form['category']->render(array('class' => 'size289'))?>
			</div>
		</div>
		<div class="search-col">
			<div class="b-search">
				<div class="inside">
					<div class="b-btn">
						<input name="" type="submit" value="" />
					</div>
					<div class="b-input">
						<?php echo $form['search']->render(array('title' => $form->getDefault('search')))?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	cuselActivate(10);
</script>
<?php end_slot()?>