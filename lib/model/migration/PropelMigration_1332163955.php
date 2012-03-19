<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332163955.
 * Generated on 2012-03-19 17:32:35 by madesst
 */
class PropelMigration_1332163955
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
CREATE TABLE board_archive
(
	id INTEGER NOT NULL,
	is_public BOOLEAN DEFAULT \'t\' NOT NULL,
	name VARCHAR(128) NOT NULL,
	sf_guard_user_profile_id INTEGER NOT NULL,
	category_id INTEGER NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE category_archive
(
	id INTEGER NOT NULL,
	name VARCHAR(128) NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE clip_archive
(
	id INTEGER NOT NULL,
	source_id INTEGER NOT NULL,
	name VARCHAR(128) NOT NULL,
	url VARCHAR NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE scene_time_archive
(
	id INTEGER NOT NULL,
	reclip_id INTEGER NOT NULL,
	scene_time DECIMAL NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	unique_comments_count INTEGER DEFAULT 0 NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE INDEX scene_time_archive_I_1 ON scene_time_archive (reclip_id,scene_time);

CREATE TABLE reclip_archive
(
	id INTEGER NOT NULL,
	sf_guard_user_profile_id INTEGER NOT NULL,
	clip_id INTEGER NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id,sf_guard_user_profile_id)
);

CREATE INDEX reclip_archive_I_1 ON reclip_archive (id);

CREATE TABLE scene_like_archive
(
	like_sf_guard_user_profile_id INTEGER NOT NULL,
	scene_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (like_sf_guard_user_profile_id,scene_id)
);

CREATE TABLE scene_repin_archive
(
	repin_sf_guard_user_profile_id INTEGER NOT NULL,
	scene_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (repin_sf_guard_user_profile_id,scene_id)
);

CREATE TABLE comment_archive
(
	id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	reply_to_comment_id INTEGER,
	sf_guard_user_profile_id INTEGER NOT NULL,
	scene_time_id INTEGER NOT NULL,
	text TEXT NOT NULL,
	rating INTEGER DEFAULT 0 NOT NULL,
	rating_votes_count INTEGER DEFAULT 0 NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE clip_follower_archive
(
	clip_id INTEGER NOT NULL,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (clip_id,follower_sf_guard_user_profile_id)
);

CREATE TABLE board_follower_archive
(
	board_id INTEGER NOT NULL,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (board_id,follower_sf_guard_user_profile_id)
);
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
DROP TABLE IF EXISTS board_archive CASCADE;

DROP TABLE IF EXISTS category_archive CASCADE;

DROP TABLE IF EXISTS clip_archive CASCADE;

DROP TABLE IF EXISTS scene_time_archive CASCADE;

DROP TABLE IF EXISTS reclip_archive CASCADE;

DROP TABLE IF EXISTS scene_like_archive CASCADE;

DROP TABLE IF EXISTS scene_repin_archive CASCADE;

DROP TABLE IF EXISTS comment_archive CASCADE;

DROP TABLE IF EXISTS clip_follower_archive CASCADE;

DROP TABLE IF EXISTS board_follower_archive CASCADE;
',
);
	}

}