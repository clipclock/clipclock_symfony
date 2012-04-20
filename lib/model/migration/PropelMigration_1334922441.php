<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334922441.
 * Generated on 2012-04-20 15:47:21 by madesst
 */
class PropelMigration_1334922441
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
ALTER TABLE sf_guard_user_profile RENAME COLUMN last_feed_depth TO last_feed_update_depth;
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
ALTER TABLE sf_guard_user_profile RENAME COLUMN last_feed_update_depth TO last_feed_depth;
',
);
	}

}