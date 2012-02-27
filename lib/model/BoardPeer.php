<?php



/**
 * Skeleton subclass for performing query and update operations on the 'board' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.3 on:
 *
 * Mon Feb  6 03:06:04 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class BoardPeer extends BaseBoardPeer {

    public static function getCountByUserId($user_id)
    {
        $c = new Criteria();
        $c->add(self::SF_GUARD_USER_PROFILE_ID, $user_id);
        return self::doCount($c);
    }

	public static function retrieveIdsLinkedBoardsByUserId($board_id, $user_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn(BoardPeer::ID);
		$c->setPrimaryTableName(BoardPeer::TABLE_NAME);
		$c->addJoin(self::ID, ScenePeer::BOARD_ID, Criteria::INNER_JOIN);
		$c->addJoin(ScenePeer::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(SceneTimePeer::CLIP_ID, ClipPeer::ID, Criteria::INNER_JOIN);

		$c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $user_id);
		$c->addGroupByColumn(self::ID);
		$c->addAscendingOrderByColumn(self::ID . ' is distinct from '.$board_id);
		$c->addDescendingOrderByColumn('sum(' . SceneTimePeer::UNIQUE_COMMENTS_COUNT . ')');

		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function createOrReturnId($name, $user_id)
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(BoardPeer::ID);
		$c->setPrimaryTableName(BoardPeer::TABLE_NAME);
		$c->add(BoardPeer::SF_GUARD_USER_PROFILE_ID, $user_id);
		$c->add(BoardPeer::NAME, $name);
		$c->setLimit(1);

		$already = BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
		if($already && $already['id'])
		{
			return $already['id'];
		}

		$board = new Board();
		$board->setName($name);
		$board->setSfGuardUserProfileId($user_id);
		$board->setCategoryId(CategoryPeer::DEFAULT_CATEGORY_ID);
		$board->save();
		return $board->getId();
	}
} // BoardPeer
