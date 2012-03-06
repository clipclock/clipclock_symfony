<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1331029226.
 * Generated on 2012-03-06 14:20:26 by madesst
 */
class PropelMigration_1331029226
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
CREATE TABLE comment_rating_votes
(
	sf_guard_user_profile_id INTEGER NOT NULL,
	comment_id INTEGER NOT NULL,
	vote INTEGER DEFAULT 0 NOT NULL,
	id serial NOT NULL,
	PRIMARY KEY (id)
);

ALTER TABLE comment RENAME COLUMN rating_votes TO rating_votes_count;

ALTER TABLE comment_rating_votes ADD CONSTRAINT comment_rating_votes_FK_1
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE comment_rating_votes ADD CONSTRAINT comment_rating_votes_FK_2
	FOREIGN KEY (comment_id)
	REFERENCES comment (id);
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
DROP TABLE IF EXISTS comment_rating_votes CASCADE;

ALTER TABLE comment RENAME COLUMN rating_votes_count TO rating_votes;
',
);
	}

}