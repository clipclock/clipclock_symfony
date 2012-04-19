<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334873872.
 * Generated on 2012-04-20 02:17:52 by madesst
 */
class PropelMigration_1334873872
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
CREATE UNIQUE INDEX reclip_content_key ON reclip (sf_guard_user_profile_id,clip_id);

CREATE INDEX reclip_archive_I_2 ON reclip_archive (sf_guard_user_profile_id,clip_id);
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
	ALTER TABLE reclip DROP CONSTRAINT reclip_content_key;
	
DROP INDEX reclip_archive_I_2;
',
);
	}

}