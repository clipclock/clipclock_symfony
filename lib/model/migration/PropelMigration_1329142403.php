<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1329142403.
 * Generated on 2012-02-13 18:13:23 by madesst
 */
class PropelMigration_1329142403
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
ALTER TABLE scene DROP CONSTRAINT scene_fk_4;

ALTER TABLE scene RENAME COLUMN repin_scene_id TO repin_origin_scene_id;

ALTER TABLE scene DROP COLUMN is_repin;

ALTER TABLE scene ADD CONSTRAINT scene_FK_4
	FOREIGN KEY (repin_origin_scene_id)
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
ALTER TABLE scene DROP CONSTRAINT scene_FK_4;

ALTER TABLE scene RENAME COLUMN repin_origin_scene_id TO repin_scene_id;

ALTER TABLE scene ADD is_repin BOOLEAN DEFAULT \'f\' NOT NULL;

ALTER TABLE scene ADD CONSTRAINT scene_fk_4
	FOREIGN KEY (repin_scene_id)
	REFERENCES scene (id);
',
);
	}

}