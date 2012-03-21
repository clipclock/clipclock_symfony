<?php

/**
 * Category form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class CategoryForm extends BaseCategoryForm
{
  public function configure()
  {
	  unset($this['board_refs_category_list']);
  }
}
