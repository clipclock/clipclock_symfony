<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332518722.
 * Generated on 2012-03-23 20:05:22 by madesst
 */
class PropelMigration_1332518722
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
ALTER TABLE sf_guard_user ADD ref_user_id INTEGER;

ALTER TABLE sf_guard_user ADD CONSTRAINT sf_guard_user_FK_1
	FOREIGN KEY (ref_user_id)
	REFERENCES sf_guard_user (id)
	ON DELETE CASCADE;
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
ALTER TABLE sf_guard_user DROP CONSTRAINT sf_guard_user_FK_1;

ALTER TABLE sf_guard_user DROP COLUMN ref_user_id;
',
);
	}

}