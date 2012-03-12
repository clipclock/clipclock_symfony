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
		$this->pager = $this->getVar('pager');
		$this->current_user = $this->getVar('current_user');
		$this->user = $this->getVar('user');
		$this->pager->init();
		$this->boards_ids = $this->pager->getResults();
	}
	public function executeScenes()
	{
		$this->pager = $this->getVar('pager');
		$this->current_user = $this->getVar('current_user');
		$this->user = $this->getVar('user');
		$this->pager->init();
		$this->clips_ids = $this->pager->getResults();
	}
	public function executeLikes()
	{
		$this->pager = $this->getVar('pager');
		$this->current_user = $this->getVar('current_user');
		$this->user = $this->getVar('user');
		$this->pager->init();
		$this->clips_ids = $this->pager->getResults();
	}

    public function executeFollow()
    {
        $this->active = (!isset($this->active)) ? false : $this->active;
        $this->state_names = (!isset($this->state_names)) ? array('Follow User', 'Unfollow User') : $this->state_names;
        $this->sf_routes = (!isset($this->sf_routes)) ? array('follow_user', 'unfollow_user') : $this->sf_routes;
        $this->id_key = (!isset($this->id_key)) ? 'user_id' : $this->id_key;
        $this->id = (!isset($this->id)) ? null : $this->id;
    }

    private function executeNavigation()
    {
		$this->avatar_img = ImagePreview::c14n($this->user->getId(), 'medium', 'avatar');
        $this->nick = $this->user->getNick();
        $this->getContext()->getConfiguration()->loadHelpers(array('Navigation'));
    }

    public function executeNavigationPath()
    {
        $this->executeNavigation();
    }

    public function executeNavigationPerson()
    {
        /**
         * @var $this->user SfGuardUserProfile
         */

        $this->fullname = $this->user->getFirstName() . ' ' . $this->user->getLastName();
        $this->boards_count = 1; //BoardPeer::
        $this->pins_count = 1; //BoardPeer::
        $this->likes_count = 1; //BoardPeer::
        $this->comments_count = 1; //BoardPeer::
        $this->executeNavigation();
    }
}
