<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334922897.
 * Generated on 2012-04-20 15:54:57 by madesst
 */
class PropelMigration_1334922897
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
ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET DEFAULT now()-interval\'3 day\';
UPDATE sf_guard_user_profile SET last_feed_update_at = now()-interval\'3 day\' WHERE last_feed_update_at IS NULL;
ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET NOT NULL;
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
ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at DROP NOT NULL;

ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at DROP DEFAULT;
',
);
	}

}