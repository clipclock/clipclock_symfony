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

	public static function repinSceneTimeBySceneTimeUserId($scene_time, $user_id)
	{
		$new_scene_time = new SceneTime();
		$new_scene_time->setSceneTime($scene_time->getSceneTime());
		$new_scene_time->setReclipId(ReclipPeer::repinReclipBySceneIdUserId($scene_time->getId(), $user_id));
		$new_scene_time->setCreatedAt(time());
		$new_scene_time->save();
		return $new_scene_time->getId();
	}

	public static function retrieveClipsCount($board_id, Criteria $c = null)
	{
		$c = !$c ? new Criteria() : $c;

		$c->clearSelectColumns();
		$c->setPrimaryTableName(self::TABLE_NAME);
		$c->addSelectColumn(ReclipPeer::CLIP_ID);
		$c->addJoin(self::ID, ScenePeer::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->addJoin(self::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->add(ScenePeer::BOARD_ID, $board_id);
		$c->addGroupByColumn(ReclipPeer::CLIP_ID);
		$c->setDistinct();

		return BasePeer::doCount($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function retrieveClipsIdsByBoard($board_id, $limit = 9)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->setPrimaryTableName(self::TABLE_NAME);
		$c->addSelectColumn(ReclipPeer::CLIP_ID);
		/*$c->addSelectColumn(self::SCENE_TIME.' as scene_time');
		$c->addSelectColumn(ScenePeer::ID.' as scene_id');*/

		$c->addJoin(self::ID, ScenePeer::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->addJoin(self::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->add(ScenePeer::BOARD_ID, $board_id);

		$c->addGroupByColumn(ReclipPeer::CLIP_ID);
		$c->addGroupByColumn('date_trunc(\'day\', '.self::CREATED_AT.')');
		/*$c->addGroupByColumn(self::SCENE_TIME);
		$c->addGroupByColumn(ScenePeer::ID);*/
		$c->addDescendingOrderByColumn('date_trunc(\'day\', '.self::CREATED_AT.')');
		$c->addDescendingOrderByColumn('max('.self::UNIQUE_COMMENTS_COUNT.')');
		$c->addDescendingOrderByColumn('count('.self::ID.')');
		$c->setLimit($limit);

		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function retrieveClipsIdsForListByBoardId($board_id, Criteria $c = null)
	{
		$c = !$c ? new Criteria() : $c;

		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::RECLIP_ID);

		$c->addJoin(ScenePeer::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->add(ScenePeer::BOARD_ID, $board_id);

		$c->addDescendingOrderByColumn('max(' . ScenePeer::CREATED_AT . ')');

		$c->addGroupByColumn(SceneTimePeer::RECLIP_ID);

		return $c;
	}

	public static function retrieveClipsIdsForMainByUserId(Criteria $c = null, $user_id = null, $categories_id = null)
	{
		$c = !$c ? new Criteria() : $c;

		$c->setPrimaryTableName(ReclipPeer::TABLE_NAME);
		$c->clearSelectColumns();
		$c->addSelectColumn(ReclipPeer::ID.' as reclip_id');
		$c->addJoin(ReclipPeer::ID, SceneTimePeer::RECLIP_ID, Criteria::LEFT_JOIN);
		$c->addJoin(SceneTimePeer::ID, ScenePeer::SCENE_TIME_ID, Criteria::LEFT_JOIN);
		$c->addJoin(ReclipPeer::CLIP_ID, ClipPeer::ID, Criteria::LEFT_JOIN);
		$c->addJoin(ClipPeer::CLIP_SOCIAL_INFO_ID, ClipSocialInfoPeer::ID, Criteria::LEFT_JOIN);
		$c->addJoin(ScenePeer::ID, SceneLikePeer::SCENE_ID, Criteria::LEFT_JOIN);

		$c->addAlias('repin_scene', ScenePeer::TABLE_NAME);
		$c->addJoin(ScenePeer::ID, ScenePeer::alias('repin_scene', ScenePeer::REPIN_ORIGIN_SCENE_ID), Criteria::LEFT_JOIN);

		$c->addMultipleJoin(array(
			array(ClipSocialInfoPeer::EXT_USER_ID, ExtUserFollowerPeer::FOLLOWING_EXT_USER_ID),
			array(ExtUserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, $user_id)
		), Criteria::LEFT_JOIN);

		if($categories_id)
		{
			$c->addJoin(ScenePeer::BOARD_ID, BoardRefsCategoryPeer::BOARD_ID, Criteria::LEFT_JOIN);
			$c->add(BoardRefsCategoryPeer::CATEGORY_ID, $categories_id, Criteria::IN);
			if($user_id)
			{
				$criterion = $c->getNewCriterion(ClipPeer::CLIP_SOCIAL_INFO_ID, null, Criteria::ISNOTNULL);
				$criterion->addAnd($c->getNewCriterion(SceneTimePeer::RECLIP_ID, null, Criteria::ISNULL));
				$criterion->addAnd($c->getNewCriterion(ExtUserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, null, Criteria::ISNOTNULL));
				$c->addOr($criterion);
			}
			$c->addDescendingOrderByColumn('avg('. BoardRefsCategoryPeer::VOTES.')/avg(avg('. BoardRefsCategoryPeer::VOTES.')) OVER (order by max('.ScenePeer::BOARD_ID.') ASC)');
		}
		$c->addDescendingOrderByColumn('date_trunc(\'day\', coalesce(max('.ScenePeer::alias('repin_scene', ScenePeer::CREATED_AT).'), max('.self::CREATED_AT.')))');
		$c->addDescendingOrderByColumn('count('.SceneLikePeer::SCENE_ID.')');
		$c->addDescendingOrderByColumn('max('.self::UNIQUE_COMMENTS_COUNT.')');
		$c->addDescendingOrderByColumn('count('.SceneTimePeer::ID.')');
		$c->addDescendingOrderByColumn('max('.self::CREATED_AT.')');
		$c->addDescendingOrderByColumn(ReclipPeer::ID);

		$c->add(ClipPeer::HIDE, false);
		$c->add(ScenePeer::SCENE_TIME_ID, null, Criteria::ISNOTNULL);
		if($user_id)
		{
			$c->addOr(ScenePeer::SF_GUARD_USER_PROFILE_ID, $user_id);
			$criterion = $c->getNewCriterion(ClipPeer::CLIP_SOCIAL_INFO_ID, null, Criteria::ISNOTNULL);
			$criterion->addAnd($c->getNewCriterion(SceneTimePeer::RECLIP_ID, null, Criteria::ISNULL));
			$criterion->addAnd($c->getNewCriterion(ExtUserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, null, Criteria::ISNOTNULL));
			$c->addOr($criterion);
		}

		$c->addGroupByColumn(ReclipPeer::ID);
		$c->addGroupByColumn(ReclipPeer::CLIP_ID);
		return $c;
	}

	public static function doSelectForPager( $c ) {
		return parent::doSelectStmt( $c );
	}

	public static function doCountForPager(Criteria $c ) {
		$c->clearSelectColumns();
		$c->addSelectColumn('count('.SceneTimePeer::RECLIP_ID.') as count');
		$c->clearGroupByColumns();
		$c->clearOrderByColumns();

		return parent::doSelectStmt( $c )->fetch(PDO::FETCH_ASSOC);
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

	public static function modifyCriteriaByFilter(Criteria $c, $user_id, $with_my_scenes = true)
	{
		$criterions = array();

		$c->addMultipleJoin(array(
			array(ScenePeer::SF_GUARD_USER_PROFILE_ID, UserFollowerPeer::FOLLOWING_SF_GUARD_USER_PROFILE_ID),
			array(UserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, $user_id),
			array(ScenePeer::CREATED_AT, UserFollowerPeer::CREATED_AT, Criteria::GREATER_EQUAL)
		), Criteria::LEFT_JOIN);

		$criterions[] = $c->getNewCriterion(UserFollowerPeer::FOLLOWING_SF_GUARD_USER_PROFILE_ID, null, Criteria::ISNOTNULL);

		$c->addMultipleJoin(array(
			array(ScenePeer::BOARD_ID, BoardFollowerPeer::BOARD_ID),
			array(BoardFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, $user_id),
			array(ScenePeer::CREATED_AT, BoardFollowerPeer::CREATED_AT, Criteria::GREATER_EQUAL)
		), Criteria::LEFT_JOIN);

		$criterions[] = $c->getNewCriterion(BoardFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, null, Criteria::ISNOTNULL);

		//$c->addJoin(SceneTimePeer::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->addMultipleJoin(array(
			array(ReclipPeer::CLIP_ID, ClipFollowerPeer::CLIP_ID),
			array(ClipFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, $user_id),
			array(ScenePeer::CREATED_AT, ClipFollowerPeer::CREATED_AT, Criteria::GREATER_EQUAL)
		), Criteria::LEFT_JOIN);

		$criterions[] = $c->getNewCriterion(ClipFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, null, Criteria::ISNOTNULL);

		//$c->addOr(ExtUserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, null, Criteria::ISNOTNULL);

		$final_criterion = null;
		foreach($criterions as $criterion)
		{
			if(!$final_criterion)
			{
				$final_criterion = $criterion;
			}
			else
			{
				$final_criterion->addOr($criterion);
			}
		}
		$final_criterion->addOr($c->getNewCriterion(ExtUserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, null, Criteria::ISNOTNULL));
		//$final_criterion->addOr($criteria->getNewCriterion(ScenePeer::SF_GUARD_USER_PROFILE_ID, $user_id));

		$c->addAnd($final_criterion);
		if($with_my_scenes)
		{
			$c->addOr($c->getNewCriterion(ScenePeer::SF_GUARD_USER_PROFILE_ID, $user_id));
		}
		$c->addOr(ScenePeer::SCENE_TIME_ID, null, Criteria::ISNULL);

		return $c;
	}

	public static function modifyCriteriaBySearchFilter(Criteria $c, $search_string)
	{
		$search_string = pg_escape_string($search_string);
		$descr_criterion = $c->getNewCriterion(ScenePeer::TEXT, 'lower('.ScenePeer::TEXT.') like lower(\'%'.$search_string.'%\')', Criteria::CUSTOM);
		$clip_name_criterion = $c->getNewCriterion(ClipPeer::NAME, 'lower('.ClipPeer::NAME.') like lower(\'%'.$search_string.'%\')', Criteria::CUSTOM);
		$descr_criterion->addOr($clip_name_criterion);
		$c->add($descr_criterion);

		return $c;
	}
} // SceneTimePeer
