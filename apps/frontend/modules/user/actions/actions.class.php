<?php

/**
 * user actions.
 *
 * @package    videopin
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */

	public function executeConnect(sfWebRequest $request)
	{
		$this->getUser()->connect('facebook');
		return sfView::NONE;
	}

	public function executeFacebook(sfWebRequest $request)
	{
		$this->redirect('@homepage');
	}
}
