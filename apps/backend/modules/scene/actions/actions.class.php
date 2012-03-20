<?php

require_once dirname(__FILE__).'/../lib/sceneGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/sceneGeneratorHelper.class.php';

/**
 * scene actions.
 *
 * @package    videopin
 * @subpackage scene
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class sceneActions extends autoSceneActions
{
	public function preExecute()
	{
		parent::preExecute();
	}

	public function executeDeleteClip(sfWebRequest $request)
	{
		$this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

		$scene = $this->getRoute()->getObject();
		$scene->getSceneTime()->getReclip()->getClip()->delete();

		$this->getUser()->setFlash('notice', 'The item was deleted successfully.');

		$this->redirect('@scene');
	}

	public function executeBatchDelete_clip(sfWebRequest $request)
	{
		$ids = $request->getParameter('ids');

		$count = 0;

		foreach (ClipPeer::retrieveBySceneIds($ids) as $object)
		{
			$this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $object)));

			$object->delete();
			if ($object->isDeleted())
			{
				$count++;
			}
		}

		if ($count >= 0)
		{
			$this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
		}
		else
		{
			$this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items.');
		}

		$this->redirect('@scene');
	}

	public function executeHideClip(sfWebRequest $request)
	{
		$this->dispatcher->notify(new sfEvent($this, 'admin.hide_clip', array('object' => $this->getRoute()->getObject())));

		$scene = $this->getRoute()->getObject();
		$action_type = '';

		if($scene->getSceneTime()->getReclip()->getClip()->getHide())
		{
			$scene->getSceneTime()->getReclip()->getClip()->setHide(false);
			$action_type = 'un';
		}
		else
		{
			$scene->getSceneTime()->getReclip()->getClip()->setHide(true);
		}

		$scene->getSceneTime()->getReclip()->getClip()->save();

		$this->getUser()->setFlash('notice', 'The item was '.$action_type.'hided successfully.');

		$this->redirect('@scene');
	}

	public function executeBatchHide_clip(sfWebRequest $request)
	{
		$ids = $request->getParameter('ids');

		$count = 0;

		foreach (ClipPeer::retrieveBySceneIds($ids) as $object)
		{
			$this->dispatcher->notify(new sfEvent($this, 'admin.hide_clip', array('object' => $object)));

			$object->setHide(true);
			$$object->save();
			if($object->getHide())
			{
				$count++;
			}
		}

		if ($count >= 0)
		{
			$this->getUser()->setFlash('notice', 'The selected items have been changed successfully.');
		}
		else
		{
			$this->getUser()->setFlash('error', 'A problem occurs when changing the selected items.');
		}

		$this->redirect('@scene');
	}

	public function executeRefreshFrame(sfWebRequest $request)
	{
		$this->Scene = $this->getRoute()->getObject();

		$c14n_id = $this->Scene->getSceneTime()->getReclip()->getClipId().$this->Scene->getSceneTime()->getSceneTime();
		ImagePreview::deleteAllImages($c14n_id);

		$publish_helper = new AMQPPublisher();
		$publish_helper->jobScene($c14n_id, $this->Scene->getSceneTime()->getReclip()->getClip()->getUrl(), $this->Scene->getSceneTime()->getSceneTime());
		$this->redirect('@scene');
	}
}
