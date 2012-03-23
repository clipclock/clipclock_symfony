<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1332517739.
 * Generated on 2012-03-23 19:48:59 by madesst
 */
class PropelMigration_1332517739
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
ALTER TABLE invites DROP CONSTRAINT invites_pkey;

ALTER TABLE invites DROP COLUMN id;

ALTER TABLE invites ADD PRIMARY KEY (sf_guard_user_profile_id,ext_id);
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
ALTER TABLE invites DROP CONSTRAINT invites_pkey;

ALTER TABLE invites ADD id serial NOT NULL;

ALTER TABLE invites ADD PRIMARY KEY (id);
',
);
	}

}