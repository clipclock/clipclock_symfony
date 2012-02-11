<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1328957004.
 * Generated on 2012-02-11 14:43:24 by madesst
 */
class PropelMigration_1328957004
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
CREATE TABLE ext_profile
(
	id serial NOT NULL,
	created_at TIMESTAMP,
	sf_guard_user_profile_id INTEGER NOT NULL,
	ext_id VARCHAR(64) NOT NULL,
	ext_link VARCHAR(128) NOT NULL,
	PRIMARY KEY (id)
);

ALTER TABLE board DROP CONSTRAINT board_fk_1;

ALTER TABLE board RENAME COLUMN sf_guard_user_id TO sf_guard_user_profile_id;

ALTER TABLE board ADD CONSTRAINT board_FK_1
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE comment DROP CONSTRAINT comment_fk_1;

ALTER TABLE comment RENAME COLUMN sf_guard_user_id TO sf_guard_user_profile_id;

ALTER TABLE comment ADD CONSTRAINT comment_FK_1
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE follower DROP CONSTRAINT follower_pkey;

ALTER TABLE follower DROP CONSTRAINT follower_fk_1;

ALTER TABLE follower DROP CONSTRAINT follower_fk_2;

ALTER TABLE follower RENAME COLUMN left_sf_guard_user_id TO left_sf_guard_user_profile_id;

ALTER TABLE follower RENAME COLUMN right_sf_guard_user_id TO right_sf_guard_user_profile_id;

ALTER TABLE follower ADD PRIMARY KEY (left_sf_guard_user_profile_id,right_sf_guard_user_profile_id);

ALTER TABLE follower ADD CONSTRAINT follower_FK_1
	FOREIGN KEY (left_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE follower ADD CONSTRAINT follower_FK_2
	FOREIGN KEY (right_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE history DROP CONSTRAINT history_fk_1;

ALTER TABLE history DROP CONSTRAINT history_fk_5;

ALTER TABLE history DROP CONSTRAINT history_fk_6;

ALTER TABLE history RENAME COLUMN sf_guard_user_id TO sf_guard_user_profile_id;

ALTER TABLE history RENAME COLUMN follower_sf_guard_user_id TO follower_sf_guard_user_profile_id;

ALTER TABLE history RENAME COLUMN follow_sf_guard_user_id TO follow_sf_guard_user_profile_id;

ALTER TABLE history ADD CONSTRAINT history_FK_1
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE history ADD CONSTRAINT history_FK_5
	FOREIGN KEY (follower_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE history ADD CONSTRAINT history_FK_6
	FOREIGN KEY (follow_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE scene DROP CONSTRAINT scene_fk_1;

ALTER TABLE scene ADD sf_guard_user_profile_id INTEGER NOT NULL;

ALTER TABLE scene DROP COLUMN sf_guard_user_id;

ALTER TABLE scene ADD CONSTRAINT scene_FK_1
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE scene_like DROP CONSTRAINT scene_like_pkey;

ALTER TABLE scene_like DROP CONSTRAINT scene_like_fk_1;

ALTER TABLE scene_like RENAME COLUMN like_sf_guard_user_id TO like_sf_guard_user_profile_id;

ALTER TABLE scene_like ADD PRIMARY KEY (like_sf_guard_user_profile_id,scene_id);

ALTER TABLE scene_like ADD CONSTRAINT scene_like_FK_1
	FOREIGN KEY (like_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE sf_guard_user_profile DROP COLUMN ext_id;

ALTER TABLE sf_guard_user_profile DROP COLUMN ext_link;

ALTER TABLE ext_profile ADD CONSTRAINT ext_profile_FK_1
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
DROP TABLE ext_profile CASCADE;

ALTER TABLE board DROP CONSTRAINT board_FK_1;

ALTER TABLE board RENAME COLUMN sf_guard_user_profile_id TO sf_guard_user_id;

ALTER TABLE board ADD CONSTRAINT board_fk_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE comment DROP CONSTRAINT comment_FK_1;

ALTER TABLE comment RENAME COLUMN sf_guard_user_profile_id TO sf_guard_user_id;

ALTER TABLE comment ADD CONSTRAINT comment_fk_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE follower DROP CONSTRAINT follower_pkey;

ALTER TABLE follower DROP CONSTRAINT follower_FK_1;

ALTER TABLE follower DROP CONSTRAINT follower_FK_2;

ALTER TABLE follower RENAME COLUMN left_sf_guard_user_profile_id TO left_sf_guard_user_id;

ALTER TABLE follower RENAME COLUMN right_sf_guard_user_profile_id TO right_sf_guard_user_id;

ALTER TABLE follower ADD PRIMARY KEY (left_sf_guard_user_id,right_sf_guard_user_id);

ALTER TABLE follower ADD CONSTRAINT follower_fk_1
	FOREIGN KEY (left_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE follower ADD CONSTRAINT follower_fk_2
	FOREIGN KEY (right_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE history DROP CONSTRAINT history_FK_1;

ALTER TABLE history DROP CONSTRAINT history_FK_5;

ALTER TABLE history DROP CONSTRAINT history_FK_6;

ALTER TABLE history RENAME COLUMN sf_guard_user_profile_id TO sf_guard_user_id;

ALTER TABLE history RENAME COLUMN follower_sf_guard_user_profile_id TO follower_sf_guard_user_id;

ALTER TABLE history RENAME COLUMN follow_sf_guard_user_profile_id TO follow_sf_guard_user_id;

ALTER TABLE history ADD CONSTRAINT history_fk_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE history ADD CONSTRAINT history_fk_5
	FOREIGN KEY (follower_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE history ADD CONSTRAINT history_fk_6
	FOREIGN KEY (follow_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE scene DROP CONSTRAINT scene_FK_1;

ALTER TABLE scene ADD sf_guard_user_id serial NOT NULL;

ALTER TABLE scene DROP COLUMN sf_guard_user_profile_id;

ALTER TABLE scene ADD CONSTRAINT scene_fk_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE scene_like DROP CONSTRAINT scene_like_pkey;

ALTER TABLE scene_like DROP CONSTRAINT scene_like_FK_1;

ALTER TABLE scene_like RENAME COLUMN like_sf_guard_user_profile_id TO like_sf_guard_user_id;

ALTER TABLE scene_like ADD PRIMARY KEY (like_sf_guard_user_id,scene_id);

ALTER TABLE scene_like ADD CONSTRAINT scene_like_fk_1
	FOREIGN KEY (like_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sf_guard_user_profile ADD ext_id VARCHAR(64) NOT NULL DEFAULT 0;

ALTER TABLE sf_guard_user_profile ADD ext_link VARCHAR(128) NOT NULL DEFAULT 0;
',
);
	}

}