<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332940086.
 * Generated on 2012-03-28 17:08:06 by madesst
 */
class PropelMigration_1332940086
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
CREATE TABLE sf_combine
(
	asset_key VARCHAR(40) NOT NULL,
	files TEXT NOT NULL,
	PRIMARY KEY (asset_key)
);
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
DROP TABLE IF EXISTS sf_combine CASCADE;
',
);
	}

}