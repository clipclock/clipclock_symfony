<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */
class userComponents extends sfComponents
{
	public function executeInfo()
	{
		$this->user = $this->getVar('user');
		$this->ext_profiles = $this->user->getExtProfiles();
		$this->avatar_img = ImagePreview::c14n($this->user->getId(), 'big', 'avatar');
	}

	public function executeFollowersList()
	{
		$this->user = $this->getVar('user');
		$this->followers = $this->user->getFollowers();
		$this->followings = $this->user->getFollowings();

		$counts = UserFollowerPeer::countFollowersAndFollowingByUserId($this->user->getId());
		$this->followers_count = $counts['followers_count'];
		$this->followings_count = $counts['followings_count'];
	}

	public function executeFollowersListUser()
	{
		$this->user_id = $this->getVar('user_id');

		$this->user = SfGuardUserProfilePeer::retrieveByPK($this->user_id);
	}

	public function executeHistory()
	{
		$this->user = $this->getVar('user');
		$this->events = HistoryPeer::retrieveLatestEventsByUserId($this->user->getId());
	}

	public function executeBoards()
	{
		$this->user = $this->getVar('user');
		$this->boards = $this->user->getBoards();
	}

    public function executeFollow()
    {
        $this->active = (!isset($this->active)) ? false : $this->active;
        $this->state_names = (!isset($this->state_names)) ? array('Follow User', 'Unfollow User') : $this->state_names;
        $this->sf_routes = (!isset($this->sf_routes)) ? array('follow_user', 'unfollow_user') : $this->sf_routes;
        $this->id_key = (!isset($this->id_key)) ? 'user_id' : $this->id_key;
        $this->id = (!isset($this->id)) ? null : $this->id;
    }

    public function executeNavigation()
    {
		$this->avatar_img = ImagePreview::c14n($this->current_scene->getSfGuardUserProfile()->getId(), 'small', 'avatar');
        $this->nick = $this->current_scene->getSfguardUserProfile()->getNick();
        $this->getContext()->getConfiguration()->loadHelpers(array('Navigation'));
    }
}
