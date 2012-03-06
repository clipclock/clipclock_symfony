<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1331027916.
 * Generated on 2012-03-06 13:58:36 by madesst
 */
class PropelMigration_1331027916
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
ALTER TABLE comment ADD rating INTEGER DEFAULT 0 NOT NULL;

ALTER TABLE comment ADD rating_votes INTEGER DEFAULT 0 NOT NULL;
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
ALTER TABLE comment DROP COLUMN rating;

ALTER TABLE comment DROP COLUMN rating_votes;
',
);
	}

}