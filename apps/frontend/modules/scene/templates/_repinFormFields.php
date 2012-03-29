<?php if($form):?>
<?php echo $form->renderHiddenFields()?>
<?php if(isset($form['board_id'])):?>
<h4>Choose channel:</h4>
<div class="line-form">
	<?php echo $form['board_id']->render(array('class' => 'size300'))?>
</div>
<h4>Or create new:</h4>
<?php else:?>
<h4>Create new board:</h4>
<?php endif;?>
<div class="inside">

	<div class="b-input">
		<?php echo $form['board']['name']?>
	</div>
</div>
<?php endif;?>