
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
<?php slot('category_modal') ?>
<?php include_component('home', 'categoriesSelector', array('current_user' => $current_user, 'categories' => $categories, 'sf_cache_key' => $categories))?>
<?php end_slot()?>
<!-- b-filter  -->
<div class="b-filter">
	<form id="filter_form" action="<?php echo url_for('homepage_bind')?>" method="post">
		<div class="col">
			<label>Show me</label>
			<div class="line-form">
				<?php echo $form->renderHiddenFields()?>
				<?php echo $form['source']->render(array('class' => 'size164'))?>
			</div>
		</div>
		<div id="categories_selected" class="col">
			<label>Interest</label>
			<div class="line-form">
				<div class="cusel size289" id="cuselFrame-home_filter_source" style="width:164px" tabindex="0"><div class="cuselFrameRight"></div>
					<div class="cuselText"><?php echo $categories_selected_text?></div></div>
			</div>
		</div>
		<!--div class="search-col">
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
		</div-->
	</form>
</div>
<script type="text/javascript">
	cuselActivate(15);
</script>