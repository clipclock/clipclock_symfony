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

	public static function retrieveFirstSceneTimeIdByClipIdBoardId($clip_id, $board_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn(SceneTimePeer::ID . ' as scene_time_id');
		$c->addSelectColumn(self::ID);
		$c->addSelectColumn(SceneTimePeer::UNIQUE_COMMENTS_COUNT);

		$c->add(self::BOARD_ID, $board_id);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->add(SceneTimePeer::CLIP_ID, $clip_id);
		$c->addAscendingOrderByColumn(SceneTimePeer::SCENE_TIME);
		$c->setLimit(1);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function retrieveAscSceneTimeIdByClipIdBoardId($clip_id, $board_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn(self::ID);
		$c->addSelectColumn(SceneTimePeer::SCENE_TIME);

		$c->add(self::BOARD_ID, $board_id);
		$c->addJoin(self::SCENE_TIME_ID, SceneTimePeer::ID, Criteria::INNER_JOIN);
		$c->add(SceneTimePeer::CLIP_ID, $clip_id);
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
		$c->addAscendingOrderByColumn(SceneTimePeer::SCENE_TIME);
		$c->setLimit(1);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
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
} // ScenePeer
