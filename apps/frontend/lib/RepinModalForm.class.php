<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lmaxim
 * Date: 2/20/12
 * Time: 12:52 PM
 * To change this template use File | Settings | File Templates.
 */
 
class RepinModalForm extends SceneForm {

    public function configure()
    {
        $this->getObject()->setSfGuardUserProfileId($this->getOption('sf_guard_user_profile_id'));

        $c = new Criteria();
        $c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $this->getObject()->getSfGuardUserProfileId());

        $this->setWidget(
          'board_id', new sfWidgetFormPropelChoice(array('model' => 'Board', 'add_empty' => false, 'criteria' => $c))
        );

        $this->widgetSchema->setNameFormat('repin_modal_form[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);


    }

}
