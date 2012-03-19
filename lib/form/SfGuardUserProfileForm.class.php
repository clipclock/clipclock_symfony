<?php

/**
 * SfGuardUserProfile form.
 *
 * @package    videopin
 * @subpackage form
 * @author     Your name here
 */
class SfGuardUserProfileForm extends BaseSfGuardUserProfileForm
{
  public function configure()
  {
	  unset($this['board_follower_list']);
	  unset($this['clip_follower_list']);
	  unset($this['scene_comment_rating_votes_list']);
	  unset($this['scene_like_list']);
	  unset($this['scene_repin_list']);
  }
}
