<?php if ($field->isPartial()): ?>
  <?php include_partial('scene/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
  <?php include_component('scene', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <div class="<?php echo $class ?><?php $form[$name]->hasError() and print ' errors' ?>">
    <?php echo $form[$name]->renderError() ?>
    <div>
      <?php echo $form[$name]->renderLabel($label) ?>

      <div class="content">
		  <?php if($name == 'scene_time'):?>
		  <p>
			  <?php foreach(ImagePreview::$sizes['scene'] as $key => $size):?>
			  <?php echo $key?> (<?php echo $size?>): <img src="<?php echo ImagePreview::c14n($form->getOption('c14n_id'), $key) ?>" alt="" /><br />
			  <?php endforeach?>
		  </p>
		  <?php endif;?>
		  <?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>
	  </div>

      <?php if ($help): ?>
        <div class="help"><?php echo __($help, array(), 'messages') ?></div>
      <?php elseif ($help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo $help ?></div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
