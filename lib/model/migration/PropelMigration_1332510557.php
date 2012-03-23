<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332510557.
 * Generated on 2012-03-23 17:49:17 by madesst
 */
class PropelMigration_1332510557
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
CREATE TABLE board_refs_user_votes
(
	board_id INTEGER NOT NULL,
	sf_guard_user_profile_id INTEGER NOT NULL,
	PRIMARY KEY (board_id)
);

CREATE TABLE invites
(
	created_at TIMESTAMP,
	sf_guard_user_profile_id INTEGER NOT NULL,
	ext_id VARCHAR(80) NOT NULL,
	id serial NOT NULL,
	PRIMARY KEY (id)
);

ALTER TABLE board_refs_user_votes ADD CONSTRAINT board_refs_user_votes_FK_1
	FOREIGN KEY (board_id)
	REFERENCES board (id);

ALTER TABLE board_refs_user_votes ADD CONSTRAINT board_refs_user_votes_FK_2
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE invites ADD CONSTRAINT invites_FK_1
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);
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
DROP TABLE IF EXISTS board_refs_user_votes CASCADE;

DROP TABLE IF EXISTS invites CASCADE;
',
);
	}

}