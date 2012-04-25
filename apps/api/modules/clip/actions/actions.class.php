<?php

/**
 * authorization actions.
 *
 * @package    videopin
 * @subpackage clip
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class clipActions extends sfActions
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

  public function executeGet(sfWebRequest $request)
  {
    $this->setTemplate('index');
  }

  public function executeUpload(sfWebRequest $request)
  {
    $this->setTemplate('index');
  }

}
