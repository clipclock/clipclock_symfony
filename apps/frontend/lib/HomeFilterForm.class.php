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

	public function configure()
	{

		$choices = $this->getSources();

		$this->setWidget('source', new sfWidgetFormChoice(array('choices' => $choices)));
		$this->setValidator('source', new sfValidatorChoice(array('choices' => array_keys($choices), 'required' => false)));

		$choices = $this->getCategories();

		$this->setWidget('category', new sfWidgetFormChoice(array('choices' => $choices)));
		$this->setValidator('category', new sfValidatorChoice(array('choices' => array_keys($choices), 'required' => false)));

		$this->setWidget('search', new sfWidgetFormInput());
		$this->setValidator('search', new sfValidatorString(array('required' => false)));

		$this->setDefault('search', 'Search');
		$this->widgetSchema->setNameFormat( 'home_filter[%s]' );

		$this->disableCSRFProtection();
	}

	protected  function getSources()
	{
		$choices = array(
			'1' => 'Everything',
			'2' => 'I Follow',
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

	protected function getCategories()
	{
		$choices = array(
			self::ALL_CATEGORIES_ID => 'Everything'
		);
		$categories = CategoryPeer::doSelect(new Criteria());
		foreach($categories as $category)
		{
			$choices[$category->getId()] = $category->getName();
		}

		return $choices;
	}
}