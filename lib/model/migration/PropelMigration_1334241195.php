<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334241195.
 * Generated on 2012-04-11 23:04:43 
 */
class PropelMigration_1334241195
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
ALTER TABLE clip ADD duration INTEGER DEFAULT 0 NOT NULL;

ALTER TABLE clip_archive ADD duration INTEGER DEFAULT 0 NOT NULL;
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
ALTER TABLE clip DROP COLUMN duration;

ALTER TABLE clip_archive DROP COLUMN duration;
',
);
	}

}