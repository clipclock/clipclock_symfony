<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lmaxim
 * Date: 2/27/12
 * Time: 10:02 PM
 * To change this template use File | Settings | File Templates.
 */
 
class NewBoardForm extends BoardForm {

  public function configure()
  {
        parent::setup();

        $this->setWidgets(array(
            'id'                       => new sfWidgetFormInputHidden(),
            'is_public'                       => new sfWidgetFormInputHidden(),
            'name'                     => new sfWidgetFormInputText(),
            'sf_guard_user_profile_id' => new sfWidgetFormInputHidden(),
        ));

        $this->setValidators(array(
          'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
          'is_public'                => new sfValidatorBoolean(),
          'name'                     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
          'sf_guard_user_profile_id' => new sfValidatorPropelChoice(array('model' => 'SfGuardUserProfile', 'column' => 'sf_guard_user_id', 'required' => false)),
        ));

        $this->setDefault('sf_guard_user_profile_id', $this->getOption('sf_guard_user_profile_id'));
        $this->getObject()->setSfGuardUserProfileId($this->getOption('sf_guard_user_profile_id'));

  }
}
