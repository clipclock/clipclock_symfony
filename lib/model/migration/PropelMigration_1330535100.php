<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1330535100.
 * Generated on 2012-02-29 21:05:00 by madesst
 */
class PropelMigration_1330535100
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
CREATE TABLE reclip
(
	id serial NOT NULL,
	sf_guard_user_profile_id INTEGER NOT NULL,
	clip_id INTEGER NOT NULL,
	PRIMARY KEY (id,sf_guard_user_profile_id)
);
CREATE UNIQUE INDEX reclip_id_key ON reclip (id);

ALTER TABLE scene_time DROP CONSTRAINT scene_time_fk_1;

ALTER TABLE scene DROP CONSTRAINT scene_FK_2;
ALTER TABLE comment DROP CONSTRAINT comment_FK_3;

	DROP INDEX scene_time_id_key;
	
ALTER TABLE scene_time RENAME COLUMN clip_id TO reclip_id;

CREATE UNIQUE INDEX scene_time_id_key ON scene_time (reclip_id,scene_time);

ALTER TABLE comment ADD CONSTRAINT comment_FK_3
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

truncate scene_time cascade;
ALTER TABLE scene ADD CONSTRAINT scene_FK_2
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);






ALTER TABLE scene_time ADD CONSTRAINT scene_time_FK_1
	FOREIGN KEY (reclip_id)
	REFERENCES reclip (id);

ALTER TABLE reclip ADD CONSTRAINT reclip_FK_1
	FOREIGN KEY (sf_guard_user_profile_id)
	REFERENCES sf_guard_user_profile (sf_guard_user_id);

ALTER TABLE reclip ADD CONSTRAINT reclip_FK_2
	FOREIGN KEY (clip_id)
	REFERENCES clip (id);
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
DROP TABLE reclip CASCADE;


ALTER TABLE scene DROP CONSTRAINT scene_FK_2;
ALTER TABLE comment DROP CONSTRAINT comment_FK_3;
	DROP INDEX scene_time_id_key;
	
ALTER TABLE scene_time RENAME COLUMN reclip_id TO clip_id;

CREATE UNIQUE INDEX scene_time_id_key ON scene_time (clip_id,scene_time);


ALTER TABLE comment ADD CONSTRAINT comment_FK_3
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

ALTER TABLE scene ADD CONSTRAINT scene_FK_2
	FOREIGN KEY (scene_time_id)
	REFERENCES scene_time (id);

ALTER TABLE scene_time ADD CONSTRAINT scene_time_fk_1
	FOREIGN KEY (clip_id)
	REFERENCES clip (id);
',
);
	}

}