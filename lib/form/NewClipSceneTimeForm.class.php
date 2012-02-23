<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 22.02.12
 * Time: 13:31
 * To change this template use File | Settings | File Templates.
 */
class NewClipSceneTimeForm extends SceneTimeForm
{
	public function configure()
	{
		parent::configure();
		unset($this['clip_id']);
		$this->embedForm('clip_id', new ClipForm($this->getOption('clip')));
		$this->validatorSchema->setPostValidator(
			new sfValidatorPass()
		);
	}
}