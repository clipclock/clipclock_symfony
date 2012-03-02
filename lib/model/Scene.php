<?php



/**
 * Skeleton subclass for representing a row from the 'scene' table.
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
class Scene extends BaseScene {

	public function getUsernameSlug()
	{
		return $this->getSfGuardUserProfile()->getNick();
	}

	public function __toString()
	{
		return $this->getText();
	}
} // Scene
