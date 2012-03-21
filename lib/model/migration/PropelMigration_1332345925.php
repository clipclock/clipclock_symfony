<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332345925.
 * Generated on 2012-03-21 20:05:25 by madesst
 */
class PropelMigration_1332345925
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
CREATE TABLE board_refs_category
(
	board_id INTEGER NOT NULL,
	category_id INTEGER NOT NULL,
	votes INTEGER DEFAULT 1 NOT NULL,
	PRIMARY KEY (board_id,category_id)
);

ALTER TABLE board DROP CONSTRAINT board_fk_2;

ALTER TABLE board DROP COLUMN category_id;

ALTER TABLE board_archive DROP COLUMN category_id;

ALTER TABLE board_refs_category ADD CONSTRAINT board_refs_category_FK_1
	FOREIGN KEY (board_id)
	REFERENCES board (id);

ALTER TABLE board_refs_category ADD CONSTRAINT board_refs_category_FK_2
	FOREIGN KEY (category_id)
	REFERENCES category (id);
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
DROP TABLE IF EXISTS board_refs_category CASCADE;

ALTER TABLE board ADD category_id INTEGER NOT NULL;

ALTER TABLE board ADD CONSTRAINT board_fk_2
	FOREIGN KEY (category_id)
	REFERENCES category (id);

ALTER TABLE board_archive ADD category_id INTEGER NOT NULL;
',
);
	}

}