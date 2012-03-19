<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1331811682.
 * Generated on 2012-03-15 15:41:22 by madesst
 */
class PropelMigration_1331811682
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
ALTER TABLE sf_guard_user ADD salt VARCHAR(128);

ALTER TABLE sf_guard_user ADD password VARCHAR(128);
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
ALTER TABLE sf_guard_user DROP COLUMN salt;

ALTER TABLE sf_guard_user DROP COLUMN password;
',
);
	}

}