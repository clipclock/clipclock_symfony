<?php slot('homepage_filter') ?>
<?php if(!$user):?>
<div class="welcome">
	<div class="close"></div>
	<div class="inner">
		<h1>Welcome, you're new, aren't you?</h1>
		<h2>See and add a video, comment on the length of time. <a href="#">How does it work?</a></h2>
	</div>
</div>
<?php endif; ?>
<!-- /welcome -->
<!-- b-filter  -->
<div class="b-filter">
	<form action="<?php echo url_for('homepage')?>" method="post">
		<div class="col">
			<label>Show me</label>
			<div class="line-form">
				<?php echo $form['source']?>
			</div>
		</div>
		<div class="col">
			<label>Interest</label>
			<div class="line-form">
				<?php echo $form['category']?>
			</div>
		</div>
		<div class="search-col">
			<div class="b-search">
				<div class="inside">
					<div class="b-btn">
						<input name="" type="submit" value="" />
					</div>
					<div class="b-input">
						<?php echo $form['search']?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php end_slot()?>