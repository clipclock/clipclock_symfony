<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1328694310.
 * Generated on 2012-02-08 13:45:10 by madesst
 */
class PropelMigration_1328694310
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
create table sf_guard_user_profile (
	sf_guard_user_id int4 not null,
	first_name varchar(128),
	last_name varchar(128),
	nick varchar(64) not null,
	ext_id varchar(64) not null,
	ext_link varchar(128) not null
);

ALTER TABLE sf_guard_user_profile ADD PRIMARY KEY (sf_guard_user_id);

ALTER TABLE sf_guard_user_profile ADD CONSTRAINT sf_guard_user_profile_FK_1
	FOREIGN KEY (sf_guard_user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sf_guard_user ADD COLUMN email varchar(128) not null;

ALTER TABLE sf_guard_user DROP COLUMN salt;
ALTER TABLE sf_guard_user DROP COLUMN password;

CREATE UNIQUE INDEX sf_guard_user_email_idx ON sf_guard_user (email);
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
DROP TABLE sf_guard_user_profile;
DROP INDEX sf_guard_user_email_idx;
ALTER TABLE sf_guard_user DROP COLUMN email;
ALTER TABLE sf_guard_user ADD COLUMN salt varchar(128) not null;
ALTER TABLE sf_guard_user ADD COLUMN password varchar(128) not null;
',
);
	}

}