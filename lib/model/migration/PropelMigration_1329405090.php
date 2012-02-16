<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1329405090.
 * Generated on 2012-02-16 19:11:30 by madesst
 */
class PropelMigration_1329405090
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
ALTER TABLE scene_like ADD created_at TIMESTAMP DEFAULT now() NOT NULL;

ALTER TABLE scene_repin ADD created_at TIMESTAMP DEFAULT now() NOT NULL;
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
ALTER TABLE scene_like DROP COLUMN created_at;

ALTER TABLE scene_repin DROP COLUMN created_at;
',
);
	}

}