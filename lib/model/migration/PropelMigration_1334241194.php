<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334241194.
 * Generated on 2012-04-12 18:33:14 by madesst
 */
class PropelMigration_1334241194
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
ALTER TABLE token ALTER COLUMN token_key TYPE VARCHAR;

ALTER TABLE token ALTER COLUMN token_secret TYPE VARCHAR;

ALTER TABLE token ALTER COLUMN params TYPE VARCHAR;

CREATE UNIQUE INDEX token_key ON token (token_key);
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
	ALTER TABLE token DROP CONSTRAINT token_key;
	
ALTER TABLE token ALTER COLUMN token_key TYPE TEXT;

ALTER TABLE token ALTER COLUMN token_secret TYPE TEXT;

ALTER TABLE token ALTER COLUMN params TYPE TEXT;
',
);
	}

}