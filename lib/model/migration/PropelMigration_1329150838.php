<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1329150838.
 * Generated on 2012-02-13 20:33:58 by madesst
 */
class PropelMigration_1329150838
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
ALTER TABLE comment DROP CONSTRAINT comment_fk_3;
ALTER TABLE scene DROP CONSTRAINT scene_fk_2;

ALTER TABLE scene_time DROP CONSTRAINT scene_time_pkey;

DROP INDEX scene_time_id_key;

ALTER TABLE scene_time ADD PRIMARY KEY (id);

ALTER TABLE scene ADD CONSTRAINT scene_FK_2
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

ALTER TABLE comment ADD CONSTRAINT comment_FK_3
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

CREATE UNIQUE INDEX scene_time_id_key ON scene_time (clip_id,scene_time);
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
ALTER TABLE comment DROP CONSTRAINT comment_fk_3;
ALTER TABLE scene DROP CONSTRAINT scene_fk_2;

ALTER TABLE scene_time DROP CONSTRAINT scene_time_pkey;

DROP INDEX scene_time_id_key;

ALTER TABLE scene_time ADD PRIMARY KEY (id,clip_id,scene_time);

CREATE UNIQUE INDEX scene_time_id_key ON scene_time (id);

ALTER TABLE scene ADD CONSTRAINT scene_FK_2
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

ALTER TABLE comment ADD CONSTRAINT comment_FK_3
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

',
);
	}

}