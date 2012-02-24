<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1330106839.
 * Generated on 2012-02-24 18:07:19 by root
 */
class PropelMigration_1330106839
{

	public function preUp($manager)
	{
		// add the pre-migration code here
	}

	public function postUp($manager)
	{
		// add the post-migration code here
	}

	public function preDown($manager)
	{
		// add the pre-migration code here
	}

	public function postDown($manager)
	{
		// add the post-migration code here
	}

	/**
	 * Get the SQL statements for the Up migration
	 *
	 * @return array list of the SQL strings to execute for the Up migration
	 *               the keys being the datasources
	 */
	public function getUpSQL()
	{
		return array (
  'propel' => '
ALTER TABLE board_follower DROP CONSTRAINT board_follower_pkey;

ALTER TABLE board_follower ALTER COLUMN board_id SET NOT NULL;

ALTER TABLE board_follower ADD PRIMARY KEY (board_id,follower_sf_guard_user_profile_id);

ALTER TABLE clip_follower DROP CONSTRAINT clip_follower_pkey;

ALTER TABLE clip_follower ADD PRIMARY KEY (clip_id,follower_sf_guard_user_profile_id);
',
);
	}

	/**
	 * Get the SQL statements for the Down migration
	 *
	 * @return array list of the SQL strings to execute for the Down migration
	 *               the keys being the datasources
	 */
	public function getDownSQL()
	{
		return array (
  'propel' => '
ALTER TABLE board_follower DROP CONSTRAINT board_follower_pkey;

ALTER TABLE board_follower ALTER COLUMN board_id DROP NOT NULL;

ALTER TABLE board_follower ADD PRIMARY KEY (follower_sf_guard_user_profile_id);

ALTER TABLE clip_follower DROP CONSTRAINT clip_follower_pkey;

ALTER TABLE clip_follower ADD PRIMARY KEY (follower_sf_guard_user_profile_id);
',
);
	}

}