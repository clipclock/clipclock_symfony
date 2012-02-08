<?php

class myUser extends sfMelodyUser
{
	public function getId()
	{
		$guard_user = $this->getGuardUser();
		return $guard_user ? $guard_user->getId() : 0;
	}

	public function getNick()
	{
		return $this->getProfile()->getNick();
	}
}
