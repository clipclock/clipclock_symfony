<?php



/**
 * Skeleton subclass for performing query and update operations on the 'sf_guard_user_profile' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.3 on:
 *
 * Wed Feb  8 00:25:11 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class SfGuardUserProfilePeer extends BaseSfGuardUserProfilePeer {

	const FOLLOWERS = 1;
	const FOLLOWINGS = 2;
	const SCENE_LIKES = 3;
	const SCENE_REPINS = 4;
	const SCENE_COMMENTS = 5;

	public static $objects_types = array(
		self::FOLLOWERS => 'followers',
		self::FOLLOWINGS => 'followings',
		self::SCENE_LIKES => 'scene_likes',
		self::SCENE_REPINS => 'scene_repins',
		self::SCENE_COMMENTS => 'scene_comments'
	);
	public static $objects_types_names = array(
		self::FOLLOWERS => 'Followers',
		self::FOLLOWINGS => 'Followings',
		self::SCENE_LIKES => 'Likes',
		self::SCENE_REPINS => 'Repins',
		self::SCENE_COMMENTS => 'Comments'
	);
    
	public static function retrieveCriteriaForListingByObjectIdAndTypeId($object_id, $object_type)
	{
		$c = new Criteria();
		$c->setPrimaryTableName(self::TABLE_NAME);
		switch($object_type)
		{
			case self::FOLLOWERS:
				$c->addMultipleJoin(array(
					array(self::SF_GUARD_USER_ID, UserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID),
					array(UserFollowerPeer::FOLLOWING_SF_GUARD_USER_PROFILE_ID, $object_id)
				), Criteria::INNER_JOIN);
				$c->addDescendingOrderByColumn(UserFollowerPeer::CREATED_AT);
				break;
			case self::FOLLOWINGS:
				$c->addMultipleJoin(array(
					array(self::SF_GUARD_USER_ID, UserFollowerPeer::FOLLOWING_SF_GUARD_USER_PROFILE_ID),
					array(UserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, $object_id)
				), Criteria::INNER_JOIN);
				$c->addDescendingOrderByColumn(UserFollowerPeer::CREATED_AT);
				break;
			case self::SCENE_LIKES:
				$c->addMultipleJoin(array(
					array(self::SF_GUARD_USER_ID, SceneLikePeer::LIKE_SF_GUARD_USER_PROFILE_ID),
					array(SceneLikePeer::SCENE_ID, $object_id)
				), Criteria::INNER_JOIN);
				break;
			case self::SCENE_REPINS:
				$c->addMultipleJoin(array(
					array(self::SF_GUARD_USER_ID, SceneRepinPeer::REPIN_SF_GUARD_USER_PROFILE_ID),
					array(SceneRepinPeer::SCENE_ID, $object_id)
				), Criteria::INNER_JOIN);
				break;
			case self::SCENE_COMMENTS:
				$c->addJoin(self::SF_GUARD_USER_ID, SceneCommentPeer::SF_GUARD_USER_PROFILE_ID, Criteria::INNER_JOIN);

				$c->addMultipleJoin(array(
					array(self::SF_GUARD_USER_ID, ScenePeer::SF_GUARD_USER_PROFILE_ID),
					array(ScenePeer::SCENE_TIME_ID, SceneCommentPeer::SCENE_TIME_ID)
				), Criteria::INNER_JOIN);
				$c->addGroupByColumn(self::SF_GUARD_USER_ID);
				break;
		}
		$c->clearSelectColumns();
		$c->addSelectColumn(self::SF_GUARD_USER_ID. ' as user_id');
		return $c;
	}

	public static function doSelectForPager( $c ) {
		return parent::doSelectStmt( $c );
	}
} // SfGuardUserProfilePeer
