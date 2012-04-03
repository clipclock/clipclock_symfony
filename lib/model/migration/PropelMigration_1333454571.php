<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1333454571.
 * Generated on 2012-04-03 16:02:51 by madesst
 */
class PropelMigration_1333454571
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
ALTER TABLE scene ADD ext_id VARCHAR(64);

ALTER TABLE scene_archive ADD ext_id VARCHAR(64);
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
ALTER TABLE scene DROP COLUMN ext_id;

ALTER TABLE scene_archive DROP COLUMN ext_id;
',
);
	}

}