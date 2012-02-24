<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1330000696.
 * Generated on 2012-02-23 12:38:16 by root
 */
class PropelMigration_1330000696
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
CREATE TABLE clip_follower
(
	clip_id INTEGER NOT NULL,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	PRIMARY KEY (follower_sf_guard_user_profile_id)
);

CREATE TABLE board_follower
(
	board_id INTEGER,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	PRIMARY KEY (follower_sf_guard_user_profile_id)
);

ALTER TABLE clip_follower ADD CONSTRAINT clip_follower_FK_1
	FOREIGN KEY (clip_id)
	REFERENCES clip (id);

ALTER TABLE clip_follower ADD CONSTRAINT clip_follower_FK_2
	FOREIGN KEY (follower_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE board_follower ADD CONSTRAINT board_follower_FK_1
	FOREIGN KEY (board_id)
	REFERENCES board (id);

ALTER TABLE board_follower ADD CONSTRAINT board_follower_FK_2
	FOREIGN KEY (follower_sf_guard_user_profile_id)
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
DROP TABLE clip_follower CASCADE;

DROP TABLE board_follower CASCADE;
',
);
	}

}