<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334932522.
 * Generated on 2012-04-20 18:35:22 by madesst
 */
class PropelMigration_1334932522
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
begin;
ALTER TABLE reclip ADD created_at TIMESTAMP;

UPDATE reclip SET created_at = (SELECT scene_time.created_at FROM scene_time WHERE scene_time.reclip_id = reclip.id ORDER BY reclip.created_at DESC LIMIT 1) WHERE created_at IS NULL;

UPDATE reclip SET created_at = now() - interval \'7 day\' WHERE created_at IS NULL;

ALTER TABLE reclip ALTER COLUMN created_at SET DEFAULT now();
ALTER TABLE reclip ALTER COLUMN created_at SET NOT NULL;

ALTER TABLE reclip_archive ADD created_at TIMESTAMP DEFAULT now() NOT NULL;

ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET DEFAULT now()-interval\'3 day\';
commit;
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
ALTER TABLE reclip DROP COLUMN created_at;

ALTER TABLE reclip_archive DROP COLUMN created_at;

ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET DEFAULT \'(now() - 3 days\';
',
);
	}

}