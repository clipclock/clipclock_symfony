<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1329134827.
 * Generated on 2012-02-13 16:07:07 by madesst
 */
class PropelMigration_1329134827
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
ALTER TABLE comment ADD created_at TIMESTAMP DEFAULT now() NOT NULL;

ALTER TABLE ext_profile ALTER COLUMN created_at SET NOT NULL;

ALTER TABLE ext_profile ALTER COLUMN created_at SET DEFAULT now();

ALTER TABLE history ALTER COLUMN created_at SET NOT NULL;

ALTER TABLE history ALTER COLUMN created_at SET DEFAULT now();

ALTER TABLE scene DROP CONSTRAINT scene_fk_2;

ALTER TABLE scene RENAME COLUMN board_id TO origin_board_id;
ALTER TABLE scene RENAME COLUMN origin_board_id TO board_id;

ALTER TABLE scene ALTER COLUMN created_at SET NOT NULL;

ALTER TABLE scene ALTER COLUMN created_at SET DEFAULT now();

ALTER TABLE scene ADD unique_comments_count INTEGER DEFAULT 1 NOT NULL;

ALTER TABLE scene ADD CONSTRAINT scene_FK_2
	FOREIGN KEY (clip_id)
	REFERENCES clip (id);

ALTER TABLE scene ADD CONSTRAINT scene_FK_3
	FOREIGN KEY (board_id)
	REFERENCES board (id);
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
ALTER TABLE comment DROP COLUMN created_at;

ALTER TABLE ext_profile ALTER COLUMN created_at DROP NOT NULL;

ALTER TABLE ext_profile ALTER COLUMN created_at SET DEFAULT now();

ALTER TABLE history ALTER COLUMN created_at DROP NOT NULL;

ALTER TABLE history ALTER COLUMN created_at SET DEFAULT now();

ALTER TABLE scene DROP CONSTRAINT scene_FK_3;

ALTER TABLE scene ALTER COLUMN created_at DROP NOT NULL;

ALTER TABLE scene ALTER COLUMN created_at SET DEFAULT now();

ALTER TABLE scene DROP COLUMN unique_comments_count;

ALTER TABLE scene DROP CONSTRAINT scene_FK_2;

ALTER TABLE scene ADD CONSTRAINT scene_fk_2
	FOREIGN KEY (board_id)
	REFERENCES board (id);
',
);
	}

}