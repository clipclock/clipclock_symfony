<?php



/**
 * Skeleton subclass for performing query and update operations on the 'scene_repin' table.
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
class SceneRepinPeer extends BaseSceneRepinPeer {

    const PINNED = 0xFF;
    const UN_PINNED = 0xEE;
    const NOT_BEEN_PINNED = 0xBB;

	public static function retrieveIdsBySceneId($scene_id)
	{
		$c = new Criteria();
		$c->add(self::SCENE_ID, $scene_id);
		$c->clearSelectColumns();
		$c->addSelectColumn(self::REPIN_SF_GUARD_USER_PROFILE_ID);
		$c->addDescendingOrderByColumn(self::CREATED_AT);
		$c->setLimit(12);

		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

    public static function isRepinnedSceneByUser($scene_id, $user_id)
    {
        $c = new Criteria();;
        $c->add(self::REPIN_SF_GUARD_USER_PROFILE_ID, $user_id);
        $c->add(self::SCENE_ID, $scene_id);
        
        return self::doCount($c);
    }

    public static function toggleBySceneIdAndUserIdByState($scene_id, $user_id, $state)
    {
        $c = new Criteria();;
        $c->add(self::REPIN_SF_GUARD_USER_PROFILE_ID, $user_id);
        $c->add(self::SCENE_ID, $scene_id);

        if ($state) {

            try {
                self::doInsert($c);
            } catch (Exception $e) {
                return false; // already isseted
            }

            return self::PINNED; // new record
        } else {
            try {
                $result = self::doDelete($c);
                ScenePeer::doDeleteBySceneId($scene_id);
            } catch (Exception $e) {
                return false; // holly crap happens
            }
        }

        return ($result) ? self::UN_PINNED: self::NOT_BEEN_PINNED; // if nothing to delete = 0, else 1

    }

} // SceneRepinPeer
