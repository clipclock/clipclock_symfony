<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1331038173.
 * Generated on 2012-03-06 16:49:33 by madesst
 */
class PropelMigration_1331038173
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
ALTER TABLE comment_rating_votes ADD sign BOOLEAN NOT NULL;

ALTER TABLE comment_rating_votes DROP COLUMN vote;
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
ALTER TABLE comment_rating_votes ADD vote INTEGER DEFAULT 0 NOT NULL;

ALTER TABLE comment_rating_votes DROP COLUMN sign;
',
);
	}

}