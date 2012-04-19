<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334831762.
 * Generated on 2012-04-19 14:36:02 by madesst
 */
class PropelMigration_1334831762
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
CREATE TABLE fb_user_follower
(
	following_fb_user_id VARCHAR NOT NULL,
	follower_sf_guard_user_profile_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	PRIMARY KEY (following_fb_user_id,follower_sf_guard_user_profile_id)
);

ALTER TABLE reclip RENAME COLUMN facebook_id TO fb_user_id;

ALTER TABLE reclip ADD fb_post_id VARCHAR;

ALTER TABLE reclip_archive RENAME COLUMN facebook_id TO fb_user_id;

ALTER TABLE reclip_archive ADD fb_post_id VARCHAR;

ALTER TABLE fb_user_follower ADD CONSTRAINT fb_user_follower_FK_1
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
DROP TABLE IF EXISTS fb_user_follower CASCADE;

ALTER TABLE reclip RENAME COLUMN fb_user_id TO facebook_id;

ALTER TABLE reclip DROP COLUMN fb_post_id;

ALTER TABLE reclip_archive RENAME COLUMN fb_user_id TO facebook_id;

ALTER TABLE reclip_archive DROP COLUMN fb_post_id;
',
);
	}

}