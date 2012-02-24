<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lmaxim
 * Date: 2/20/12
 * Time: 12:52 PM
 * To change this template use File | Settings | File Templates.
 */

class RepinModalForm extends BaseSceneForm {

    public function configure()
    {
		unset($this['scene_repost_list']);
		unset($this['scene_repin_list']);
        $this->getObject()->setSfGuardUserProfileId($this->getOption('sf_guard_user_profile_id'));

        $c = new Criteria();
        $c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $this->getObject()->getSfGuardUserProfileId());

        $fields = $this->widgetSchema->getFields();

        $this->setWidgets(array());

        foreach(array_keys($fields) as $field_name)
        {
            if (!in_array($field_name, array('scene_repin_list', 'scene_like_list')))
                $this->setWidget($field_name, new sfWidgetFormInputHidden());
        }

        $this->setValidator('scene_repin_list', new sfValidatorPass());
        $this->setValidator('scene_like_list', new sfValidatorPass());

        $this->setWidget('board_id', new sfWidgetFormPropelChoice(array('model' => 'Board', 'add_empty' => false, 'criteria' => $c)));

        $this->widgetSchema->setNameFormat('repin_modal_form[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);


    }

    public function save($con = null)
    {
        if (null === $con)
        {
            $con = $this->getConnection();
        }

        try
        {
            $con->beginTransaction();

            parent::save($con);

            SceneRepinPeer::toggleBySceneIdAndUserIdByState($this->getObject()->getRepinOriginSceneId(),
                                                            $this->getObject()->getSfGuardUserProfileId(),
                                                            true);

            $con->commit();

            return $this->getObject();
        }
        catch (Exception $e)
        {
            $con->rollBack();

            throw $e;
        }

        return null;
    }

}
