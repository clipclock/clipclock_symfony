<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1330413616.
 * Generated on 2012-02-28 11:20:16 by madesst
 */
class PropelMigration_1330413616
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
ALTER TABLE board_follower ADD created_at TIMESTAMP DEFAULT now() NOT NULL;

ALTER TABLE clip_follower ADD created_at TIMESTAMP DEFAULT now() NOT NULL;
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
ALTER TABLE board_follower DROP COLUMN created_at;

ALTER TABLE clip_follower DROP COLUMN created_at;
',
);
	}

}