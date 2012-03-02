<?php

/**
 * list actions.
 *
 * @package    videopin
 * @subpackage list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class listActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward('default', 'module');
	}

	public function executeShowUserFollowers(sfWebRequest $request)
	{

	}

	public function executeShowUserFollowings(sfWebRequest $request)
	{

	}

	public function executeShowSceneLikes(sfWebRequest $request)
	{

	}

	public function executeShowSceneRepins(sfWebRequest $request)
	{

	}

	public function executeShowSceneComments(sfWebRequest $request)
	{

	}
}
