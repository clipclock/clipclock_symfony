<?php if($form):?>
<?php echo $form->renderHiddenFields()?>
<?php if(isset($form['scene']['board_id'])):?>
<h4>Choose channel (<em>your thematic set of video clips</em>):</h4>
<div class="line-form">
	<?php echo $form['scene']['board_id']->render(array('class' => 'size300'))?>
</div>
<h4>Or create new:</h4>
<?php else:?>
<h4>Create new channel:</h4>
<?php endif;?>
<div class="inside">

<div class="b-input">
	<?php echo $form['scene']['name']->render(array('class' => 'typing'))?>
</div>
</div>
<?php endif;?>