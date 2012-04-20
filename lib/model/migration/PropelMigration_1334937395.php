<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334937395.
 * Generated on 2012-04-20 19:56:35 by madesst
 */
class PropelMigration_1334937395
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
	DROP INDEX clip_social_info_post_id_key;
	
CREATE UNIQUE INDEX clip_social_info_post_id_key ON clip_social_info (post_id,ext_user_id);

ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET DEFAULT now()-interval\'3 day\';
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
	ALTER TABLE clip_social_info DROP CONSTRAINT clip_social_info_post_id_key;
	
CREATE UNIQUE INDEX clip_social_info_post_id_key ON clip_social_info (post_id);

ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET DEFAULT \'(now() - 3 days\';
',
);
	}

}