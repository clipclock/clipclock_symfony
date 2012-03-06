<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1331041167.
 * Generated on 2012-03-06 17:39:27 by madesst
 */
class PropelMigration_1331041167
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
ALTER TABLE comment_rating_votes DROP CONSTRAINT comment_rating_votes_pkey;

ALTER TABLE comment_rating_votes DROP COLUMN id;

ALTER TABLE comment_rating_votes ADD PRIMARY KEY (sf_guard_user_profile_id,comment_id);
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
ALTER TABLE comment_rating_votes DROP CONSTRAINT comment_rating_votes_pkey;

ALTER TABLE comment_rating_votes ADD id serial NOT NULL;

ALTER TABLE comment_rating_votes ADD PRIMARY KEY (id);
',
);
	}

}