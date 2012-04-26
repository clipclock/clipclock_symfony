<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1335433204.
 * Generated on 2012-04-26 13:40:04 by lmaxim
 */
class PropelMigration_1335433204
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
DROP TABLE IF EXISTS sfoauthserveraccesstoken CASCADE;

DROP TABLE IF EXISTS sfoauthserverdeveloper CASCADE;

DROP TABLE IF EXISTS sfoauthserverrequesttoken CASCADE;

DROP TABLE IF EXISTS sfoauthserveruserscope CASCADE;

ALTER TABLE sfoauthserverconsumer RENAME TO sfOauthServerConsumer;

ALTER TABLE sfoauthservernonce RENAME TO sfOauthServerNonce;

CREATE TABLE sfOauthServerDeveloper
(
	consumer_id INTEGER NOT NULL,
	user_id INTEGER NOT NULL,
	admin BOOLEAN DEFAULT \'f\',
	id serial NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE sfOauthServerRequestToken
(
	token VARCHAR(40) NOT NULL,
	secret VARCHAR(40),
	consumer_id INTEGER NOT NULL,
	user_id INTEGER,
	callback VARCHAR(256),
	scope VARCHAR(256),
	expires INTEGER,
	protocole INTEGER DEFAULT 1,
	id serial NOT NULL,
	created_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE sfOauthServerAccessToken
(
	token VARCHAR(40) NOT NULL,
	secret VARCHAR(40),
	consumer_id INTEGER NOT NULL,
	user_id INTEGER,
	scope VARCHAR(256),
	expires INTEGER,
	protocole INTEGER DEFAULT 1,
	id serial NOT NULL,
	created_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE sfOauthServerUserScope
(
	user_id INTEGER NOT NULL,
	consumer_id INTEGER NOT NULL,
	scope VARCHAR(256),
	id serial NOT NULL,
	PRIMARY KEY (id)
);

ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET DEFAULT now()-interval\'3 day\';

	ALTER TABLE token DROP CONSTRAINT token_key;
	
ALTER TABLE token ALTER COLUMN token_key TYPE TEXT;

ALTER TABLE token ALTER COLUMN token_secret TYPE TEXT;

ALTER TABLE token ALTER COLUMN params TYPE TEXT;

ALTER TABLE sfOauthServerDeveloper ADD CONSTRAINT sfOauthServerDeveloper_FK_1
	FOREIGN KEY (consumer_id)
	REFERENCES sfOauthServerConsumer (id);

ALTER TABLE sfOauthServerDeveloper ADD CONSTRAINT sfOauthServerDeveloper_FK_2
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfOauthServerRequestToken ADD CONSTRAINT sfOauthServerRequestToken_FK_1
	FOREIGN KEY (consumer_id)
	REFERENCES sfOauthServerConsumer (id);

ALTER TABLE sfOauthServerRequestToken ADD CONSTRAINT sfOauthServerRequestToken_FK_2
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfOauthServerAccessToken ADD CONSTRAINT sfOauthServerAccessToken_FK_1
	FOREIGN KEY (consumer_id)
	REFERENCES sfOauthServerConsumer (id);

ALTER TABLE sfOauthServerAccessToken ADD CONSTRAINT sfOauthServerAccessToken_FK_2
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfOauthServerUserScope ADD CONSTRAINT sfOauthServerUserScope_FK_1
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfOauthServerUserScope ADD CONSTRAINT sfOauthServerUserScope_FK_2
	FOREIGN KEY (consumer_id)
	REFERENCES sfOauthServerConsumer (id);
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
DROP TABLE IF EXISTS sfOauthServerDeveloper CASCADE;

DROP TABLE IF EXISTS sfOauthServerRequestToken CASCADE;

DROP TABLE IF EXISTS sfOauthServerAccessToken CASCADE;

DROP TABLE IF EXISTS sfOauthServerUserScope CASCADE;

ALTER TABLE sfOauthServerConsumer RENAME TO sfoauthserverconsumer;

ALTER TABLE sfOauthServerNonce RENAME TO sfoauthservernonce;

CREATE TABLE sfoauthserveraccesstoken
(
	token VARCHAR(40) NOT NULL,
	secret VARCHAR(40),
	consumer_id INTEGER NOT NULL,
	user_id INTEGER,
	scope VARCHAR(256),
	expires INTEGER,
	protocole INTEGER DEFAULT 1,
	id serial NOT NULL,
	created_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE sfoauthserverdeveloper
(
	consumer_id INTEGER NOT NULL,
	user_id INTEGER NOT NULL,
	admin BOOLEAN DEFAULT \'f\',
	id serial NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE sfoauthserverrequesttoken
(
	token VARCHAR(40) NOT NULL,
	secret VARCHAR(40),
	consumer_id INTEGER NOT NULL,
	user_id INTEGER,
	callback VARCHAR(256),
	scope VARCHAR(256),
	expires INTEGER,
	protocole INTEGER DEFAULT 1,
	id serial NOT NULL,
	created_at TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE sfoauthserveruserscope
(
	user_id INTEGER NOT NULL,
	consumer_id INTEGER NOT NULL,
	scope VARCHAR(256),
	id serial NOT NULL,
	PRIMARY KEY (id)
);

ALTER TABLE sf_guard_user_profile ALTER COLUMN last_feed_update_at SET DEFAULT \'(now() - 3 days\';

ALTER TABLE token ALTER COLUMN token_key TYPE VARCHAR;

ALTER TABLE token ALTER COLUMN token_secret TYPE VARCHAR;

ALTER TABLE token ALTER COLUMN params TYPE VARCHAR;

CREATE UNIQUE INDEX token_key ON token (token_key);

ALTER TABLE sfoauthserveraccesstoken ADD CONSTRAINT sfoauthserveraccesstoken_fk_1
	FOREIGN KEY (consumer_id)
	REFERENCES sfoauthserverconsumer (id);

ALTER TABLE sfoauthserveraccesstoken ADD CONSTRAINT sfoauthserveraccesstoken_fk_2
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfoauthserverdeveloper ADD CONSTRAINT sfoauthserverdeveloper_fk_1
	FOREIGN KEY (consumer_id)
	REFERENCES sfoauthserverconsumer (id);

ALTER TABLE sfoauthserverdeveloper ADD CONSTRAINT sfoauthserverdeveloper_fk_2
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfoauthserverrequesttoken ADD CONSTRAINT sfoauthserverrequesttoken_fk_1
	FOREIGN KEY (consumer_id)
	REFERENCES sfoauthserverconsumer (id);

ALTER TABLE sfoauthserverrequesttoken ADD CONSTRAINT sfoauthserverrequesttoken_fk_2
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfoauthserveruserscope ADD CONSTRAINT sfoauthserveruserscope_fk_1
	FOREIGN KEY (user_id)
	REFERENCES sf_guard_user (id);

ALTER TABLE sfoauthserveruserscope ADD CONSTRAINT sfoauthserveruserscope_fk_2
	FOREIGN KEY (consumer_id)
	REFERENCES sfoauthserverconsumer (id);
',
);
	}

}