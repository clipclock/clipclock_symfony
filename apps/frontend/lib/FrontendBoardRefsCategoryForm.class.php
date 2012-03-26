<?php

/**
 * Scene form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class FrontendBoardRefsCategoryForm extends BoardRefsCategoryForm
{
	protected $user_id = null;
	public function configure()
	{
		parent::configure();
		$this->setWidget('category_id', new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => false, 'order_by' => array('Name', 'asc'), 'method' => 'getName')));
		unset($this['votes']);
		$this->setDefault('board_id', $this->getOption('board_id'));
		$this->user_id = $this->getOption('user_id');
	}

	protected function doSave($con = null)
	{
		if (null === $con)
		{
			$con = $this->getConnection();
		}

		$this->updateObject();

		// this is Propel specific
		if(isset($this->getObject()->markForDeletion))
		{
			$this->getObject()->delete($con);
		}
		else
		{
			$this->getObject()->setVotes(BoardRefsCategoryPeer::getVotesCount($this->getObject()->getBoardId(), $this->getObject()->getCategoryId())+1);
			if(BoardRefsCategoryQuery::create()->filterByBoardId($this->getObject()->getBoardId())->findByCategoryId($this->getObject()->getCategoryId())->count())
			{
				$this->getObject()->setNew(false);
			}
			$this->getObject()->save($con);
		}

		// embedded forms
		$this->saveEmbeddedForms($con);
	}

	public function save($con = null)
	{
		if (!$this->isValid())
		{
			throw $this->getErrorSchema();
		}

		if (null === $con)
		{
			$con = $this->getConnection();
		}

		try
		{
			$con->beginTransaction();

			$this->doSave($con);

			$board_refs_votes = new BoardRefsUserVotes();
			$board_refs_votes->setBoardId($this->getObject()->getBoardId());
			$board_refs_votes->setSfGuardUserProfileId($this->user_id);
			$board_refs_votes->save($con);

			$con->commit();
		}
		catch (Exception $e)
		{
			$con->rollBack();
			throw $e;

			return false;
		}

		return $this->getObject();
	}
}
