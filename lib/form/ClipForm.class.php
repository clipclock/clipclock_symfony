<?php

/**
 * Clip form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class ClipForm extends BaseClipForm
{
	public function configure()
	{
		parent::setup();
		$this->setWidgets(array(
			'id'        => new sfWidgetFormInputHidden(),
			'source_id' => new sfWidgetFormInputHidden(),
			'name'      => new sfWidgetFormInputHidden(),
			'url'       => new sfWidgetFormInputHidden(),
		));
		$this->setValidators(array(
			'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
			'source_id' => new sfValidatorString(),
			'name'      => new sfValidatorString(array('max_length' => 128)),
			'url'       => new sfValidatorString(),
		));
	}
}
