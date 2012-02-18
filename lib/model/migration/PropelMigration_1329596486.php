<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1329596486.
 * Generated on 2012-02-19 00:21:26 by madesst
 */
class PropelMigration_1329596486
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
ALTER TABLE history RENAME COLUMN follow_sf_guard_user_profile_id TO follow_of_sf_guard_user_profile_id;

ALTER TABLE history DROP COLUMN follower_sf_guard_user_profile_id;

ALTER TABLE history DROP CONSTRAINT history_fk_6;

ALTER TABLE history ADD event_type INTEGER NOT NULL;

ALTER TABLE history ADD repin_of_sf_guard_user_profile_id INTEGER;

ALTER TABLE history ADD CONSTRAINT history_FK_5
	FOREIGN KEY (follow_of_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE history ADD CONSTRAINT history_FK_6
	FOREIGN KEY (repin_of_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE sf_guard_user_profile ADD city VARCHAR(64);

ALTER TABLE sf_guard_user_profile ADD country VARCHAR(64);
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
ALTER TABLE history DROP CONSTRAINT history_FK_5;

ALTER TABLE history DROP CONSTRAINT history_FK_6;

ALTER TABLE history RENAME COLUMN follow_of_sf_guard_user_profile_id TO follow_sf_guard_user_profile_id;

ALTER TABLE history ADD follower_sf_guard_user_profile_id INTEGER;

ALTER TABLE history DROP COLUMN event_type;

ALTER TABLE history DROP COLUMN repin_of_sf_guard_user_profile_id;

ALTER TABLE history ADD CONSTRAINT history_fk_5
	FOREIGN KEY (follower_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE history ADD CONSTRAINT history_fk_6
	FOREIGN KEY (follow_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE sf_guard_user_profile DROP COLUMN city;

ALTER TABLE sf_guard_user_profile DROP COLUMN country;
',
);
	}

}