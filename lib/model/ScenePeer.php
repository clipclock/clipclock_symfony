<?php



/**
 * Skeleton subclass for performing query and update operations on the 'scene' table.
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
class ScenePeer extends BaseScenePeer {

	public static function retrieveReclipIdsByUserId($user_id)
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::RECLIP_ID);
		$c->setPrimaryTableName(self::TABLE_NAME);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->add(ScenePeer::SF_GUARD_USER_PROFILE_ID, $user_id);
		$c->addGroupByColumn(SceneTimePeer::RECLIP_ID);
		$c->addDescendingOrderByColumn('max('.self::CREATED_AT.')');
		$c->addDescendingOrderByColumn(SceneTimePeer::RECLIP_ID);

		return $c;
	}

	public static function retrieveReclipIdsByLikesUserId($user_id)
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::RECLIP_ID);
		$c->addSelectColumn('max('.self::ID.') as scene_id');
		$c->setPrimaryTableName(self::TABLE_NAME);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(self::ID, SceneLikePeer::SCENE_ID, Criteria::INNER_JOIN);
		$c->add(SceneLikePeer::LIKE_SF_GUARD_USER_PROFILE_ID, $user_id);
		$c->addGroupByColumn(SceneTimePeer::RECLIP_ID);
		$c->addDescendingOrderByColumn('max('.SceneLikePeer::CREATED_AT.')');
		$c->addDescendingOrderByColumn(SceneTimePeer::RECLIP_ID);

		return $c;
	}

	public static function retrieveReclipIdsByCommentsUserId($user_id)
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::RECLIP_ID);
		$c->addSelectColumn('max('.self::ID.') as scene_id');
		$c->setPrimaryTableName(self::TABLE_NAME);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(SceneTimePeer::ID, SceneCommentPeer::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->add(SceneCommentPeer::SF_GUARD_USER_PROFILE_ID, $user_id);
		$c->addGroupByColumn(SceneTimePeer::RECLIP_ID);
		$c->addDescendingOrderByColumn('max('.SceneCommentPeer::CREATED_AT.')');
		$c->addDescendingOrderByColumn(SceneTimePeer::RECLIP_ID);

		return $c;
	}

	public static function retrieveLatestByUserId($user_id)
	{
		$c = new Criteria();
		$c->add(self::SF_GUARD_USER_PROFILE_ID, $user_id);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(SceneTimePeer::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(self::SF_GUARD_USER_PROFILE_ID, SfGuardUserProfilePeer::SF_GUARD_USER_ID, Criteria::INNER_JOIN);
		$c->setLimit(8);
		$c->addDescendingOrderByColumn(self::CREATED_AT);

		$c->clearSelectColumns();
		$c->addSelectColumn(self::ID . ' as scene_id');
		$c->addSelectColumn(SceneTimePeer::SCENE_TIME . ' as scene_time');
		$c->addSelectColumn(ReclipPeer::CLIP_ID);
		$c->addSelectColumn(ScenePeer::BOARD_ID);
		$c->addSelectColumn(SfGuardUserProfilePeer::NICK);
		$c->addSelectColumn(SfGuardUserProfilePeer::FIRST_NAME);
		$c->addSelectColumn(SfGuardUserProfilePeer::LAST_NAME);

		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

    public static function getCountByUserId($user_id)
    {
        $c = new Criteria();
        $c->add(self::SF_GUARD_USER_PROFILE_ID, $user_id);
        $c->add(self::REPIN_ORIGIN_SCENE_ID, null, Criteria::ISNULL);
        return self::doCount($c);
    }

	public static function retrieveFirstSceneTimeIdByClipIdBoardId($reclip_id, $user_id = null, $filter_user_id = null, $filter_scene_id = null)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::SCENE_TIME);
		$c->addSelectColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);
		$c->addSelectColumn(ScenePeer::BOARD_ID);
		$c->addSelectColumn(SceneTimePeer::ID.' as scene_time_id');
		$c->addSelectColumn(ScenePeer::ID.' as scene_id');
		$c->addSelectColumn(ScenePeer::TEXT);
		$c->addSelectColumn(ScenePeer::SF_GUARD_USER_PROFILE_ID. ' as user_id');
		$c->addSelectColumn(SfGuardUserProfilePeer::NICK. ' as nick');
		$c->addSelectColumn(SfGuardUserProfilePeer::FIRST_NAME . ' as first_name');
		$c->addSelectColumn(SfGuardUserProfilePeer::LAST_NAME . ' as last_name');
		$c->addSelectColumn(ReclipPeer::CLIP_ID);
		$c->addSelectColumn(ClipPeer::NAME);

		$c->add(SceneTimePeer::RECLIP_ID, $reclip_id);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(SceneTimePeer::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(ReclipPeer::CLIP_ID, ClipPeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(ScenePeer::SF_GUARD_USER_PROFILE_ID, SfGuardUserProfilePeer::SF_GUARD_USER_ID, Criteria::INNER_JOIN);

		if($filter_user_id)
		{
			$c->addAscendingOrderByColumn(ScenePeer::SF_GUARD_USER_PROFILE_ID . ' is distinct from '.$filter_user_id);
			$c->addDescendingOrderByColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);
		}
		elseif($filter_scene_id)
		{
			$c->addAscendingOrderByColumn(ScenePeer::ID . ' is distinct from '.$filter_scene_id);
			$c->addDescendingOrderByColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);
		}
		else
		{
			$c->addDescendingOrderByColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);
			if($user_id)
			{
				$c->addAscendingOrderByColumn(ScenePeer::SF_GUARD_USER_PROFILE_ID . ' is distinct from '.$user_id);
			}
		}
		$c->setLimit(1);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function retrieveAscSceneTimeIdByClipIdBoardId($reclip_id, $board_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn(self::ID);
		$c->addSelectColumn(SceneTimePeer::SCENE_TIME);
		$c->addSelectColumn(ReclipPeer::CLIP_ID);
		$c->addSelectColumn(SceneTimePeer::ID . ' as scene_time_id');
		$c->addSelectColumn(ScenePeer::BOARD_ID);
		$c->addSelectColumn(ScenePeer::CREATED_AT);
		$c->addSelectColumn(ScenePeer::REPIN_ORIGIN_SCENE_ID);
		$c->addSelectColumn(SfGuardUserProfilePeer::SF_GUARD_USER_ID . ' as user_id');
		$c->addSelectColumn(SfGuardUserProfilePeer::NICK . ' as nick');
		$c->addSelectColumn(SfGuardUserProfilePeer::FIRST_NAME . ' as first_name');
		$c->addSelectColumn(SfGuardUserProfilePeer::LAST_NAME . ' as last_name');
		$c->addSelectColumn(ScenePeer::TEXT . ' as text');
		$c->addSelectColumn(ScenePeer::alias('repined_scene', ScenePeer::BOARD_ID) . ' as repined_board_id');
		$c->addSelectColumn(BoardPeer::alias('repined_board', BoardPeer::NAME) . ' as repined_board_name');
		$c->addSelectColumn(SfGuardUserProfilePeer::alias('repined_user', SfGuardUserProfilePeer::FIRST_NAME) . ' as repined_first_name');
		$c->addSelectColumn(SfGuardUserProfilePeer::alias('repined_user', SfGuardUserProfilePeer::LAST_NAME) . ' as repined_last_name');
		$c->addSelectColumn(SfGuardUserProfilePeer::alias('repined_user', SfGuardUserProfilePeer::NICK) . ' as repined_nick');

		//$c->add(self::BOARD_ID, $board_id);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(SceneTimePeer::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(self::SF_GUARD_USER_PROFILE_ID, SfGuardUserProfilePeer::SF_GUARD_USER_ID, Criteria::INNER_JOIN);

		$c->addAlias('repined_scene', ScenePeer::TABLE_NAME);
		$c->addJoin(ScenePeer::REPIN_ORIGIN_SCENE_ID, ScenePeer::alias('repined_scene', ScenePeer::ID), Criteria::LEFT_JOIN);

		$c->addAlias('repined_board', BoardPeer::TABLE_NAME);
		$c->addJoin(ScenePeer::alias('repined_scene', ScenePeer::BOARD_ID), BoardPeer::alias('repined_board', BoardPeer::ID), Criteria::LEFT_JOIN);

		$c->addAlias('repined_user', SfGuardUserProfilePeer::TABLE_NAME);
		$c->addJoin(ScenePeer::alias('repined_scene', ScenePeer::SF_GUARD_USER_PROFILE_ID), SfGuardUserProfilePeer::alias('repined_user', SfGuardUserProfilePeer::SF_GUARD_USER_ID), Criteria::LEFT_JOIN);

		$c->add(SceneTimePeer::RECLIP_ID, $reclip_id);
		//$c->add(self::REPIN_ORIGIN_SCENE_ID, null, Criteria::ISNULL);
		$c->addAscendingOrderByColumn(SceneTimePeer::SCENE_TIME);

		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function retrieveFirstSceneTimeIdById($id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::ID . ' as scene_time_id');
		$c->addSelectColumn(self::ID);
		$c->addSelectColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);

		$c->addJoin(SceneTimePeer::ID, self::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->add(self::ID, $id);
		$c->addAscendingOrderByColumn(self::REPIN_ORIGIN_SCENE_ID);
		$c->addAscendingOrderByColumn(SceneTimePeer::SCENE_TIME);
		$c->setLimit(1);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function doSelectForPager( $c ) {
		return parent::doSelectStmt( $c );
	}

	public static function countRepinsLikesForSceneId($scene_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn('count(' . SceneRepinPeer::REPIN_SF_GUARD_USER_PROFILE_ID . ') as repins_count');
		$c->addSelectColumn('count(' . SceneLikePeer::LIKE_SF_GUARD_USER_PROFILE_ID . ') as likes_count');

		$c->addJoin(self::ID, SceneRepinPeer::SCENE_ID, Criteria::LEFT_JOIN);
		$c->addJoin(self::ID, SceneLikePeer::SCENE_ID, Criteria::LEFT_JOIN);
		$c->add(self::ID, $scene_id);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function countLikesForSceneIdByUserId($scene_id, $sf_guard_user_id)
	{
		$c = new Criteria();

		$c->setPrimaryTableName(ScenePeer::TABLE_NAME);

		$c->clearSelectColumns();
		$c->addSelectColumn('count(' . SceneRepinPeer::REPIN_SF_GUARD_USER_PROFILE_ID . ') as repins_count');
		$c->addSelectColumn('count(' . SceneLikePeer::LIKE_SF_GUARD_USER_PROFILE_ID . ') as likes_count');

		$c->addMultipleJoin(array(
			array(ScenePeer::ID, SceneRepinPeer::SCENE_ID),
			array(SceneRepinPeer::REPIN_SF_GUARD_USER_PROFILE_ID, $sf_guard_user_id),
		), Criteria::LEFT_JOIN);

		$c->addMultipleJoin(array(
			array(ScenePeer::ID, SceneLikePeer::SCENE_ID),
			array(SceneLikePeer::LIKE_SF_GUARD_USER_PROFILE_ID, $sf_guard_user_id),
		), Criteria::LEFT_JOIN);

		$c->add(self::ID, $scene_id);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

    public static function isRepinnedSceneByUser($scene_id, $user_id)
    {
        $c = new Criteria();;
        $c->add(self::SF_GUARD_USER_PROFILE_ID, $user_id);
        $c->add(self::REPIN_ORIGIN_SCENE_ID, $scene_id);

        return self::doCount($c);
    }

	public static function retrieveBestByClipId($clip_id, $board_id)
	{
		$c = new Criteria();
		$c->setPrimaryTableName(self::TABLE_NAME);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(SceneTimePeer::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->add(self::BOARD_ID, $board_id);
		$c->add(ReclipPeer::CLIP_ID, $clip_id);
		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::SCENE_TIME);
		$c->addSelectColumn(ScenePeer::ID);
		$c->setLimit(1);

		$c->addDescendingOrderByColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);
		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function retrieveByBoardIdSceneTimeId($scene_time_id, $board_id)
	{
		$c = new Criteria();
		$c->add(self::SCENE_TIME_ID, $scene_time_id);
		$c->add(self::BOARD_ID, $board_id);
		$c->setLimit(1);

		return self::doSelectOne($c);
	}

	public static function countUniqueCommentsBySceneId($scene_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);

		$c->addJoin(SceneTimePeer::ID, self::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->add(self::ID, $scene_id);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

    public static function retrieveOriginSceneIdBySceneIdAndUserId($scene_id, $user_id)
	{
        $c = new Criteria();
        $c->add(self::REPIN_ORIGIN_SCENE_ID, $scene_id);
        $c->add(self::SF_GUARD_USER_PROFILE_ID, $user_id);

        return self::doSelectOne($c);
    }

    public static function doDeleteByOriginSceneIdAndUserId($scene_id, $user_id)
	{
		$c = new Criteria();
        $c->add(self::ID, $scene_id);
        $c->add(self::SF_GUARD_USER_PROFILE_ID, $user_id);

		return self::doDelete($c);
	}

	public static function retrieveYoungestByClipId($clip_id)
	{
		$c = new Criteria();
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(SceneTimePeer::RECLIP_ID, ReclipPeer::ID, Criteria::INNER_JOIN);
		$c->add(ReclipPeer::CLIP_ID, $clip_id);
		$c->addDescendingOrderByColumn(ScenePeer::CREATED_AT);
		$c->setLimit(1);
		return current(self::doSelectJoinSfGuardUserProfile($c));
	}
} // ScenePeer
