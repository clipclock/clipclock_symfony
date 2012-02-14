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

		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function retrieveBestByClipId($clip_id, $board_id)
	{
		$c = new Criteria();
		$c->addJoin(self::ID, ScenePeer::SCENE_TIME_ID, Criteria::INNER_JOIN);
		$c->add(ScenePeer::BOARD_ID, $board_id);
		$c->add(self::CLIP_ID, $clip_id);

		$c->addDescendingOrderByColumn(self::UNIQUE_COMMENTS_COUNT);
		return self::doSelectOne($c);
	}

	public static function countCommentsForSceneTimeId($scene_time_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->addSelectColumn('count(' . SceneCommentPeer::ID . ') as comments_count');

		$c->add(SceneCommentPeer::SCENE_TIME_ID, $scene_time_id);

		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}
} // SceneTimePeer
