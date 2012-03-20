<?php



/**
 * Skeleton subclass for representing a row from the 'sf_guard_user_profile' table.
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
class SfGuardUserProfile extends BaseSfGuardUserProfile {

	public function __toString()
	{
		return $this->getNick();
	}

	public function getFullName()
	{
		return $this->getFirstName() . ' ' . $this->getLastName();
	}

	public function getFullNameBackend()
	{
		return $this->getId() . '/' . $this->getFirstName() . ' ' . $this->getLastName();
	}

	public function getId()
	{
		return $this->getSfGuardUserId();
	}

	public function getFollowers()
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(UserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID.' as user_id');
		$c->add(UserFollowerPeer::FOLLOWING_SF_GUARD_USER_PROFILE_ID, $this->getId());
		$c->addDescendingOrderByColumn(UserFollowerPeer::CREATED_AT);
		$c->setLimit(12);
		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getFollowings()
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(UserFollowerPeer::FOLLOWING_SF_GUARD_USER_PROFILE_ID.' as user_id');
		$c->add(UserFollowerPeer::FOLLOWER_SF_GUARD_USER_PROFILE_ID, $this->getId());
		$c->addDescendingOrderByColumn(UserFollowerPeer::CREATED_AT);
		$c->setLimit(12);
		return BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);
	}
} // SfGuardUserProfile
