<?php



/**
 * Skeleton subclass for performing query and update operations on the 'reclip' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.3 on:
 *
 * Wed Feb 29 21:25:06 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class ReclipPeer extends BaseReclipPeer {

	public static function retrieveByClipIdUserId($clip_id, $user_id)
	{
		$c = new Criteria();
		$c->add(self::CLIP_ID, $clip_id);
		$c->add(self::SF_GUARD_USER_PROFILE_ID, $user_id);
		return self::doSelectOne($c);
	}

	public static function retrieveBySceneTimeId($scene_time_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();

		$c->addJoin(self::ID, SceneTimePeer::RECLIP_ID, Criteria::INNER_JOIN);
		$c->add(SceneTimePeer::ID, $scene_time_id);
		$c->setLimit(1);

		return current(self::doSelectJoinClip($c));
	}
} // ReclipPeer
