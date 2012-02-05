<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1328484127.
 * Generated on 2012-02-06 03:22:07 by madesst
 */
class PropelMigration_1328484127
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
CREATE TABLE board
(
	id serial NOT NULL,
	is_public BOOLEAN NOT NULL,
	name VARCHAR(128) NOT NULL,
	sf_guard_user_id INTEGER NOT NULL,
	category_id INTEGER NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE category
(
	id serial NOT NULL,
	name VARCHAR(128) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE clip
(
	id serial NOT NULL,
	source_id INTEGER NOT NULL,
	name VARCHAR(128) NOT NULL,
	url VARCHAR NOT NULL,
	PRIMARY KEY (id,source_id)
);

CREATE TABLE follower
(
	left_sf_guard_user_id INTEGER NOT NULL,
	right_sf_guard_user_id INTEGER NOT NULL,
	PRIMARY KEY (left_sf_guard_user_id,right_sf_guard_user_id)
);

CREATE TABLE scene
(
	id serial NOT NULL,
	created_at TIMESTAMP,
	clip_id serial NOT NULL,
	sf_guard_user_id serial NOT NULL,
	scene_time INTEGER NOT NULL,
	origin_board_id INTEGER NOT NULL,
	has_images BOOLEAN NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE scene_like
(
	like_sf_guard_user_id INTEGER NOT NULL,
	scene_id INTEGER NOT NULL,
	PRIMARY KEY (like_sf_guard_user_id,scene_id)
);

CREATE TABLE scene_repost
(
	scene_id INTEGER NOT NULL,
	board_id INTEGER NOT NULL,
	PRIMARY KEY (scene_id,board_id)
);

CREATE TABLE source
(
	id serial NOT NULL,
	name VARCHAR(128),
	PRIMARY KEY (id)
);

CREATE TABLE comment
(
	id serial NOT NULL,
	sf_guard_user_id INTEGER NOT NULL,
	scene_id INTEGER NOT NULL,
	text TEXT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE history
(
	id serial NOT NULL,
	created_at TIMESTAMP,
	sf_guard_user_id INTEGER NOT NULL,
	scene_id INTEGER,
	board_id INTEGER,
	comment_id INTEGER,
	follower_sf_guard_user_id INTEGER,
	follow_sf_guard_user_id INTEGER,
	PRIMARY KEY (id)
);

ALTER TABLE token ADD CONSTRAINT token_FK_1
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id)
	ON DELETE CASCADE;

ALTER TABLE board ADD CONSTRAINT board_FK_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE board ADD CONSTRAINT board_FK_2
	FOREIGN KEY (category_id)
	REFERENCES category (id);

ALTER TABLE clip ADD CONSTRAINT clip_FK_1
	FOREIGN KEY (source_id)
	REFERENCES source (id);

ALTER TABLE follower ADD CONSTRAINT follower_FK_1
	FOREIGN KEY (left_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE follower ADD CONSTRAINT follower_FK_2
	FOREIGN KEY (right_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE scene ADD CONSTRAINT scene_FK_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE scene ADD CONSTRAINT scene_FK_2
	FOREIGN KEY (origin_board_id)
	REFERENCES board (id);

ALTER TABLE scene_like ADD CONSTRAINT scene_like_FK_1
	FOREIGN KEY (like_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE scene_like ADD CONSTRAINT scene_like_FK_2
	FOREIGN KEY (scene_id)
	REFERENCES scene (id);

ALTER TABLE scene_repost ADD CONSTRAINT scene_repost_FK_1
	FOREIGN KEY (scene_id)
	REFERENCES scene (id);

ALTER TABLE scene_repost ADD CONSTRAINT scene_repost_FK_2
	FOREIGN KEY (board_id)
	REFERENCES board (id);

ALTER TABLE comment ADD CONSTRAINT comment_FK_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE comment ADD CONSTRAINT comment_FK_2
	FOREIGN KEY (scene_id)
	REFERENCES scene (id);

ALTER TABLE history ADD CONSTRAINT history_FK_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE history ADD CONSTRAINT history_FK_2
	FOREIGN KEY (scene_id)
	REFERENCES scene (id);

ALTER TABLE history ADD CONSTRAINT history_FK_3
	FOREIGN KEY (board_id)
	REFERENCES board (id);

ALTER TABLE history ADD CONSTRAINT history_FK_4
	FOREIGN KEY (comment_id)
	REFERENCES comment (id);

ALTER TABLE history ADD CONSTRAINT history_FK_5
	FOREIGN KEY (follower_sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE history ADD CONSTRAINT history_FK_6
	FOREIGN KEY (follow_sf_guard_user_id)
	REFERENCES sf_guard_user (id);
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
DROP TABLE board CASCADE;

DROP TABLE category CASCADE;

DROP TABLE clip CASCADE;

DROP TABLE follower CASCADE;

DROP TABLE scene CASCADE;

DROP TABLE scene_like CASCADE;

DROP TABLE scene_repost CASCADE;

DROP TABLE source CASCADE;

DROP TABLE comment CASCADE;

DROP TABLE history CASCADE;

ALTER TABLE token DROP CONSTRAINT token_FK_1;
',
);
	}

}