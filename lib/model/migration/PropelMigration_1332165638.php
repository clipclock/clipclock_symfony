<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332165638.
 * Generated on 2012-03-19 18:00:38 by madesst
 */
class PropelMigration_1332165638
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
DROP TABLE IF EXISTS category_archive CASCADE;
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
CREATE TABLE category_archive
(
	id INTEGER NOT NULL,
	name VARCHAR(128) NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id)
);
',
);
	}

}