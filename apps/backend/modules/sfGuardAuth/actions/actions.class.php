<?php
require_once(sfConfig::get('sf_root_dir').'/plugins/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function preExecute()
  {

    //sfForm::disableCSRFProtection();
  }
}