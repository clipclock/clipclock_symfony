<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfPropelORMPlugin');
    $this->enablePlugins('sfGuardPlugin');
    $this->enablePlugins('sfPropelOAuthPlugin');
    $this->enablePlugins('sfMelodyPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('sfAdminDashPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
  }
}
