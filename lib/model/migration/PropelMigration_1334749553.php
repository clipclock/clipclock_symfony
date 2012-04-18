<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1334749553.
 * Generated on 2012-04-18 15:45:53 by madesst
 */
class PropelMigration_1334749553
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
ALTER TABLE reclip ADD facebook_id VARCHAR;

ALTER TABLE reclip_archive ADD facebook_id VARCHAR;
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
ALTER TABLE reclip DROP COLUMN facebook_id;

ALTER TABLE reclip_archive DROP COLUMN facebook_id;
',
);
	}

}