<?php



/**
 * Skeleton subclass for performing query and update operations on the 'scene_time' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.3 on:
 *
 * Mon Feb 13 17:54:27 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class SceneTimePeer extends BaseSceneTimePeer {

	public static function retrieveClipsIdsByBoard($board_id, Criteria $c = null)
	{
		$c = !$c ? new Criteria() : $c;

		$c->clearSelectColumns();
		$c->addSelectColumn(self::CLIP_ID);

		$c->addJoin(self::ID, ScenePeer::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->add(ScenePeer::BOARD_ID, $board_id);

		$c->addGroupByColumn(self::CLIP_ID);
		$c->addDescendingOrderByColumn('count('. self::UNIQUE_COMMENTS_COUNT .')');
		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function retrieveClipsIdsForListByBoardId($board_id, Criteria $c = null)
	{
		$c = !$c ? new Criteria() : $c;

		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::CLIP_ID);

		$c->addJoin(ScenePeer::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->add(ScenePeer::BOARD_ID, $board_id);

		$c->addDescendingOrderByColumn('max(' . ScenePeer::CREATED_AT . ')');

		$c->addGroupByColumn(SceneTimePeer::CLIP_ID);

		return $c;
	}

	public static function retrieveClipsIdsForMainByUserId(Criteria $c = null)
	{
		$c = !$c ? new Criteria() : $c;

		$c->setPrimaryTableName(SceneTimePeer::TABLE_NAME);
		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::CLIP_ID);
		$c->addJoin(SceneTimePeer::ID, ScenePeer::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->addDescendingOrderByColumn('max('.self::UNIQUE_COMMENTS_COUNT.')');
		$c->addDescendingOrderByColumn('max('.self::CREATED_AT.')');

		$c->addGroupByColumn(SceneTimePeer::CLIP_ID);
		return $c;
	}

	public static function doSelectForPager( $c ) {
		return parent::doSelectStmt( $c );
	}

	public static function countCommentsForSceneTimeId($scene_time_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn('count(' . SceneCommentPeer::ID . ') as comments_count');

		$c->add(SceneCommentPeer::SCENE_TIME_ID, $scene_time_id);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function recountUniqueComments($scene_time_id)
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->setPrimaryTableName(SceneCommentPeer::TABLE_NAME);
		$c->add(SceneCommentPeer::SCENE_TIME_ID, $scene_time_id);
		$c->addSelectColumn(SceneCommentPeer::SF_GUARD_USER_PROFILE_ID);
		$c->addGroupByColumn(SceneCommentPeer::SF_GUARD_USER_PROFILE_ID);
		$c->setDistinct();

		$unique_comments_count = BasePeer::doCount($c)->fetch(PDO::FETCH_ASSOC);

		$scene_time = self::retrieveByPK($scene_time_id);
		$scene_time->setUniqueCommentsCount($unique_comments_count['count']);
		$scene_time->save();

		return $unique_comments_count;
	}

	public static function modifyCriteriaByFilter($criteria, $user_following = false, $board_following = false, $clip_following = false, $category_id = false)
	{
		$criterions = array();
		if($user_following)
		{
			$criterion = $criteria->getNewCriterion(ScenePeer::CREATED_AT, $user_following['created_at'], Criteria::GREATER_EQUAL);
			$criterion->addAnd($criteria->getNewCriterion(ScenePeer::SF_GUARD_USER_PROFILE_ID, $user_following['user_id']));
			$criterions[] = $criterion;
		}

		if($board_following)
		{
			$criterion = $criteria->getNewCriterion(ScenePeer::CREATED_AT, $board_following['created_at'], Criteria::GREATER_EQUAL);
			$criterion->addAnd($criteria->getNewCriterion(ScenePeer::BOARD_ID, $user_following['board_id']));
			$criterions[] = $criterion;
		}

		if($clip_following)
		{
			$criterion = $criteria->getNewCriterion(ScenePeer::CREATED_AT, $clip_following['created_at'], Criteria::GREATER_EQUAL);
			$criterion->addAnd($criteria->getNewCriterion(SceneTimePeer::CLIP_ID, $clip_following['clip_id']));
			$criterions[] = $criterion;
		}

		foreach($criterions as $criterion)
		{
			$criteria->addOr($criterion);
		}

		if($category_id != HomeFilterForm::ALL_CATEGORIES_ID)
		{
			$criteria->addJoin(ScenePeer::BOARD_ID, BoardPeer::ID, Criteria::INNER_JOIN);
			$criteria->add(BoardPeer::CATEGORY_ID, $category_id);
		}

		return $criteria;
	}
} // SceneTimePeer
