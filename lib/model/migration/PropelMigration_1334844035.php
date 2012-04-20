<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334844035.
 * Generated on 2012-04-19 18:00:35 by madesst
 */
class PropelMigration_1334844035
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
DROP TABLE IF EXISTS fb_user_follower CASCADE;

CREATE TABLE ext_user
(
	id serial NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	ext_id VARCHAR(64) NOT NULL,
	nick VARCHAR NOT NULL,
	provider_id INTEGER NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE clip_social_info
(
	id serial NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	post_id VARCHAR NOT NULL,
	description VARCHAR,
	ext_user_id INTEGER,
	PRIMARY KEY (id)
);

CREATE TABLE provider
(
	id serial NOT NULL,
	name VARCHAR(64) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE ext_user_follower
(
	following_ext_user_id INTEGER NOT NULL,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	PRIMARY KEY (following_ext_user_id,follower_sf_guard_user_profile_id)
);

ALTER TABLE clip ADD clip_social_info_id INTEGER;

ALTER TABLE clip ADD CONSTRAINT clip_FK_2
	FOREIGN KEY (clip_social_info_id)
	REFERENCES clip_social_info (id);

ALTER TABLE clip_archive ADD clip_social_info_id INTEGER;

ALTER TABLE reclip DROP COLUMN fb_user_id;

ALTER TABLE reclip DROP COLUMN fb_post_id;

ALTER TABLE reclip_archive DROP COLUMN fb_user_id;

ALTER TABLE reclip_archive DROP COLUMN fb_post_id;

ALTER TABLE sf_guard_user_profile ADD ext_user_id INTEGER;

ALTER TABLE sf_guard_user_profile ADD CONSTRAINT sf_guard_user_profile_FK_2
	FOREIGN KEY (ext_user_id)
	REFERENCES ext_user (id);

ALTER TABLE ext_user ADD CONSTRAINT ext_user_FK_1
	FOREIGN KEY (provider_id)
	REFERENCES provider (id);

ALTER TABLE clip_social_info ADD CONSTRAINT clip_social_info_FK_1
	FOREIGN KEY (ext_user_id)
	REFERENCES ext_user (id);

ALTER TABLE ext_user_follower ADD CONSTRAINT ext_user_follower_FK_1
	FOREIGN KEY (following_ext_user_id)
	REFERENCES ext_user (id);

ALTER TABLE ext_user_follower ADD CONSTRAINT ext_user_follower_FK_2
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
DROP TABLE IF EXISTS ext_user CASCADE;

DROP TABLE IF EXISTS clip_social_info CASCADE;

DROP TABLE IF EXISTS provider CASCADE;

DROP TABLE IF EXISTS ext_user_follower CASCADE;

CREATE TABLE fb_user_follower
(
	following_fb_user_id VARCHAR NOT NULL,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	PRIMARY KEY (following_fb_user_id,follower_sf_guard_user_profile_id)
);

ALTER TABLE clip DROP CONSTRAINT clip_FK_2;

ALTER TABLE clip DROP COLUMN clip_social_info_id;

ALTER TABLE clip_archive DROP COLUMN clip_social_info_id;

ALTER TABLE reclip ADD fb_user_id VARCHAR;

ALTER TABLE reclip ADD fb_post_id VARCHAR;

ALTER TABLE reclip_archive ADD fb_user_id VARCHAR;

ALTER TABLE reclip_archive ADD fb_post_id VARCHAR;

ALTER TABLE sf_guard_user_profile DROP CONSTRAINT sf_guard_user_profile_FK_2;

ALTER TABLE sf_guard_user_profile DROP COLUMN ext_user_id;

ALTER TABLE fb_user_follower ADD CONSTRAINT fb_user_follower_fk_1
	FOREIGN KEY (follower_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);
',
);
	}

}