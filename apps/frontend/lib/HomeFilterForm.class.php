<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.02.12
 * Time: 14:33
 * To change this template use File | Settings | File Templates.
 */
class HomeFilterForm extends sfForm
{
	const ALL_CATEGORIES_ID = 0;
	const I_FOLLOW_ID = 2;

	public function configure()
	{

		$choices = $this->getSources();

		$this->setWidget('source', new sfWidgetFormChoice(array('choices' => $choices)));
		$this->setValidator('source', new sfValidatorChoice(array('choices' => array_keys($choices), 'required' => false)));

		$this->setWidget('categories', new sfWidgetFormInputHidden());
		$this->setValidator('categories', new sfValidatorString(array('required' => false)));

		$this->setWidget('categories_selected', new sfWidgetFormInput());
		$this->setValidator('categories_selected', new sfValidatorString(array('required' => false)));

		$this->setWidget('search', new sfWidgetFormInput());
		$this->setValidator('search', new sfValidatorString(array('required' => false)));

		$this->setDefault('search', 'Search');
		$this->widgetSchema->setNameFormat( 'home_filter[%s]' );

		$this->disableCSRFProtection();
	}

	protected  function getSources()
	{
		$choices = array(
			self::I_FOLLOW_ID => 'I Follow',
			1 => 'Everything',
		);

		if(!$this->getOption('user') || !$this->getOption('user')->getId())
		{
			unset($choices['2']);
		}

		return $choices;
	}

	public function bind(array $taintedValues = null, array $taintedFiles = null)
	{
		if(!empty($taintedValues['search']))
		{
			if($taintedValues['search'] == $this->getDefault('search'))
			{
				unset($taintedValues['search']);
			}
		}
		parent::bind($taintedValues, $taintedFiles);
	}
}