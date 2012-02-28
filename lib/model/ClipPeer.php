<?php



/**
 * Skeleton subclass for performing query and update operations on the 'clip' table.
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
class ClipPeer extends BaseClipPeer {

	public static function retrieveByName($name)
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(self::ID);
		$c->add(self::NAME, $name);
		$c->setLimit(1);
		return BasePeer::doSelect($c)->fetch(PDO::FETCH_ASSOC);
	}

	public static function retrieveBySceneTimeId($scene_time_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();

		$c->addJoin(self::ID, SceneTimePeer::CLIP_ID, Criteria::INNER_JOIN);
		$c->add(SceneTimePeer::ID, $scene_time_id);
		$c->setLimit(1);

		return current(self::doSelectJoinSource($c));
	}

	public static function retrieveByUrlAndSourceId($url, $source_id)
	{
		$c = new Criteria();

		$c->clearSelectColumns();
		$c->add(self::URL, $url);
		$c->add(self::SOURCE_ID, $source_id);

		return self::doSelectOne($c);
	}
} // ClipPeer
