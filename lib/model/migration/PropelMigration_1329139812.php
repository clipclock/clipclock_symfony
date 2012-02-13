<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1329139812.
 * Generated on 2012-02-13 17:30:12 by madesst
 */
class PropelMigration_1329139812
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
DROP TABLE scene_repost CASCADE;

CREATE TABLE scene_time
(
	id serial NOT NULL UNIQUE,
	clip_id INTEGER NOT NULL,
	scene_time INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	unique_comments_count INTEGER DEFAULT 1 NOT NULL,
	PRIMARY KEY (id,clip_id,scene_time)
);

CREATE TABLE scene_repin
(
	repin_sf_guard_user_profile_id INTEGER NOT NULL,
	scene_id INTEGER NOT NULL,
	PRIMARY KEY (repin_sf_guard_user_profile_id,scene_id)
);

ALTER TABLE comment DROP CONSTRAINT comment_fk_2;

ALTER TABLE comment RENAME COLUMN scene_id TO reply_to_comment_id;

ALTER TABLE comment ADD scene_time_id INTEGER NOT NULL;

ALTER TABLE comment ADD CONSTRAINT comment_FK_2
	FOREIGN KEY (reply_to_comment_id)
	REFERENCES comment (id);

ALTER TABLE comment ADD CONSTRAINT comment_FK_3
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

ALTER TABLE scene DROP CONSTRAINT scene_fk_2;

ALTER TABLE scene RENAME COLUMN scene_time TO scene_time_id;

ALTER TABLE scene ADD is_repin BOOLEAN DEFAULT \'f\' NOT NULL;

ALTER TABLE scene ADD repin_scene_id INTEGER;

ALTER TABLE scene DROP COLUMN clip_id;

ALTER TABLE scene DROP COLUMN has_images;

ALTER TABLE scene DROP COLUMN unique_comments_count;

ALTER TABLE scene ADD CONSTRAINT scene_FK_2
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

ALTER TABLE scene ADD CONSTRAINT scene_FK_4
	FOREIGN KEY (repin_scene_id)
	REFERENCES scene (id);

ALTER TABLE scene_time ADD CONSTRAINT scene_time_FK_1
	FOREIGN KEY (clip_id)
	REFERENCES clip (id);

ALTER TABLE scene_repin ADD CONSTRAINT scene_repin_FK_1
	FOREIGN KEY (repin_sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE scene_repin ADD CONSTRAINT scene_repin_FK_2
	FOREIGN KEY (scene_id)
	REFERENCES scene (id);
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
DROP TABLE scene_time CASCADE;

DROP TABLE scene_repin CASCADE;

CREATE TABLE scene_repost
(
	scene_id INTEGER NOT NULL,
	board_id INTEGER NOT NULL,
	PRIMARY KEY (scene_id,board_id)
);

ALTER TABLE comment DROP CONSTRAINT comment_FK_2;


ALTER TABLE comment RENAME COLUMN reply_to_comment_id TO scene_id;

ALTER TABLE comment DROP COLUMN scene_time_id;

ALTER TABLE comment ADD CONSTRAINT comment_fk_2
	FOREIGN KEY (scene_id)
	REFERENCES scene (id);



ALTER TABLE scene DROP CONSTRAINT scene_FK_4;

ALTER TABLE scene RENAME COLUMN scene_time_id TO scene_time;

ALTER TABLE scene ADD clip_id serial NOT NULL;

ALTER TABLE scene ADD has_images BOOLEAN NOT NULL;

ALTER TABLE scene ADD unique_comments_count INTEGER DEFAULT 1 NOT NULL;

ALTER TABLE scene DROP COLUMN is_repin;

ALTER TABLE scene DROP COLUMN repin_scene_id;

ALTER TABLE scene ADD CONSTRAINT scene_fk_2
	FOREIGN KEY (clip_id)
	REFERENCES clip (id);

ALTER TABLE scene_repost ADD CONSTRAINT scene_repost_fk_1
	FOREIGN KEY (scene_id)
	REFERENCES scene (id);

ALTER TABLE scene_repost ADD CONSTRAINT scene_repost_fk_2
	FOREIGN KEY (board_id)
	REFERENCES board (id);
',
);
	}

}