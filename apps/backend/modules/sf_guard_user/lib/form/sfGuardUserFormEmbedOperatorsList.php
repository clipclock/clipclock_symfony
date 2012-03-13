<?php


class sfGuardUserFormEmbedOperatorsLst extends sfGuardUserForm
{
	public function configure()
  	{
    	parent::configure();
    	
    	if (!$this->isNew())
    	{
	    	$user_content_provider_list = UserContentProviderListPeer::retrieveByUserId($this->getObject()->getId());

	    	$user_content_provider_list_form = new UserContentProviderListForm($user_content_provider_list);	   
	    	$user_content_provider_list_form->setDefault('user_id', $this->getObject()->getId());
	    	    	
	    	$user_content_provider_list_form->widgetSchema['content_provider_list_id']->setOption('add_empty', true);
	    	$user_content_provider_list_form->validatorSchema['content_provider_list_id']->setOption('required', false);
	    	$user_content_provider_list_form->widgetSchema['user_id'] = new sfWidgetFormInputHidden();

	    	$user_content_provider_list_form->widgetSchema->getFormFormatter()->setDecoratorFormat("%content%");
	    	$user_content_provider_list_form->widgetSchema->getFormFormatter()->setRowFormat("%error%\n  %field%%help%\n%hidden_fields%\n");

	    	$this->embedForm('operators_list', $user_content_provider_list_form);
    	}
  	}
  	
	public function processValues($values)
  	{
  		if (isset($values['operators_list']) && empty($values['operators_list']['content_provider_list_id']))
  		{	
  			$user_content_provider_list = UserContentProviderListPeer::retrieveByPK($values['operators_list']['id']);
  			
  			if (!is_null($user_content_provider_list))
  				$user_content_provider_list->delete();
  				
  			unset($this->embeddedForms['operators_list']);
  			unset($values['operators_list']);
  		}
		
  		$values = parent::processValues($values);
    	return $values;
  	}
  	
  	
}