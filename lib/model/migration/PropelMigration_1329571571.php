<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1329571571.
 * Generated on 2012-02-18 17:26:11 by madesst
 */
class PropelMigration_1329571571
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
DROP TABLE follower CASCADE;

CREATE TABLE follower_user
(
	following_sf_guard_user_profile_id INTEGER NOT NULL,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	PRIMARY KEY (following_sf_guard_user_profile_id,follower_sf_guard_user_profile_id)
);

ALTER TABLE follower_user ADD CONSTRAINT follower_user_FK_1
	FOREIGN KEY (following_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE follower_user ADD CONSTRAINT follower_user_FK_2
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
DROP TABLE follower_user CASCADE;

CREATE TABLE follower
(
	left_sf_guard_user_profile_id INTEGER NOT NULL,
	right_sf_guard_user_profile_id INTEGER NOT NULL,
	PRIMARY KEY (left_sf_guard_user_profile_id,right_sf_guard_user_profile_id)
);

ALTER TABLE follower ADD CONSTRAINT follower_fk_1
	FOREIGN KEY (left_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE follower ADD CONSTRAINT follower_fk_2
	FOREIGN KEY (right_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);
',
);
	}

}