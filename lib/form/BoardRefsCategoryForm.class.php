<?php

/**
 * BoardRefsCategory form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class BoardRefsCategoryForm extends BaseBoardRefsCategoryForm
{
	public function configure()
	{
		$this->setWidget('category_id', new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => false, 'order_by' => array('Name', 'asc'))));
		$this->widgetSchema->setLabel('category_id', 'Категория');
		$this->widgetSchema->setLabel('votes', 'Голосов');
		//$this->widgetSchema->setLabel('delete', 'Удалить?');
	}
}
