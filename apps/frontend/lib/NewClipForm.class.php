<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 22.02.12
 * Time: 12:05
 * To change this template use File | Settings | File Templates.
 */

class NewClipForm extends sfForm
{
	const REGEX_URL_FORMAT = '~^
      (%s)://                                 # protocol
      (
        ([a-z0-9-]+\.)+[a-z]{2,6}             # a domain name
          |                                   #  or
        \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    # a IP address
      )
      (:[0-9]+)?                              # a port (optional)
      (/watch)                               # a /, nothing or a / with something
      (.*)
      ([\?\&]?v=.*)
    $~ix';

	public function setup()
	{
		$this->setWidgets(array(
			'url'       => new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
			'url'       => new sfValidatorUrl(array('pattern' => new sfCallable(array($this, 'generateRegex'))))
		));

		$this->widgetSchema->setNameFormat('new_clip[%s]');
		$this->setDefault('url', 'Paste and enter YouTube video URL');
		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

		parent::setup();
	}

	public function generateRegex()
	{
		return sprintf(self::REGEX_URL_FORMAT, implode('|', array('http')));
	}

	public function bind(array $taintedValues = null, array $taintedFiles = null)
	{
		if(!empty($taintedValues['url']))
		{
			if($taintedValues['url'] == $this->getDefault('url'))
			{
				unset($taintedValues['url']);
			}
		}
		parent::bind($taintedValues, $taintedFiles);
	}
}