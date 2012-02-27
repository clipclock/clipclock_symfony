<?php

class myUser extends sfMelodyUser
{
    public function getFullName()
    {
        return $this->getProfile()->getFirstName() . ' ' . $this->getProfile()->getLastName();
    }

	public function getId()
	{
		$guard_user = $this->getGuardUser();
		return $guard_user ? $guard_user->getId() : 0;
	}

	public function getNick()
	{
		return $this->getProfile()->getNick();
	}

	public function getFirstName()
	{
		return $this->getProfile()->getFirstName();
	}
}
