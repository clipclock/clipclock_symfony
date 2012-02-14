<?php



/**
 * Skeleton subclass for representing a row from the 'clip' table.
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
class Clip extends BaseClip {

	public function getFirstSceneForBoardId($board_id)
	{
		return ScenePeer::retrieveFirstByClipIdBoardId($this->getId(), $board_id);
	}
} // Clip
