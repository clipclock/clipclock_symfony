<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332157087.
 * Generated on 2012-03-19 15:38:07 by madesst
 */
class PropelMigration_1332157087
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
CREATE TABLE scene_archive
(
	id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	scene_time_id INTEGER NOT NULL,
	sf_guard_user_profile_id INTEGER NOT NULL,
	board_id INTEGER NOT NULL,
	repin_origin_scene_id INTEGER,
	text TEXT NOT NULL,
	archived_at TIMESTAMP,
	PRIMARY KEY (id)
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
DROP TABLE IF EXISTS scene_archive CASCADE;
',
);
	}

}