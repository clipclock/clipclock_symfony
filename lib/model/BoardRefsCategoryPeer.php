<?php



/**
 * Skeleton subclass for performing query and update operations on the 'board_refs_category' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.4 on:
 *
 * Wed Mar 21 20:06:01 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class BoardRefsCategoryPeer extends BaseBoardRefsCategoryPeer {

	public static function getVotesCount($board_id, $category_id)
	{
		$c = new Criteria();
		$c->add(self::BOARD_ID, $board_id);
		$c->add(self::CATEGORY_ID, $category_id);
		$c->clearSelectColumns();
		$c->addSelectColumn(self::VOTES);
		$c->setLimit(1);

		$votes = BasePeer::doSelect($c)->fetch(PDO::FETCH_COLUMN);
		return $votes ? $votes : 0;
	}
} // BoardRefsCategoryPeer
