<?php use_helper('I18N', 'Date') ?>
<?php include_partial('scene/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edit Scene', array(), 'messages') ?></h1>

  <?php include_partial('scene/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('scene/form_header', array('Scene' => $Scene, 'form' => $form, 'configuration' => $configuration)) ?>
	 Ссылка для FB: <input type=text size="160" value="<?php echo $login_url?>" />
  </div>

  <div id="sf_admin_content">
    <?php include_partial('scene/form', array('Scene' => $Scene, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('scene/form_footer', array('Scene' => $Scene, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
