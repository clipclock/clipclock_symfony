<?php



/**
 * This class defines the structure of the 'sfOauthServerConsumer' table.
 *
 *
 * This class was autogenerated by Propel 1.6.4 on:
 *
 * Wed Apr 25 12:43:10 2012
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.plugins.sfOuathPropelServerPlugin.lib.model.map
 */
class SfoauthserverconsumerTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfOuathPropelServerPlugin.lib.model.map.SfoauthserverconsumerTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
		// attributes
		$this->setName('sfOauthServerConsumer');
		$this->setPhpName('Sfoauthserverconsumer');
		$this->setClassname('Sfoauthserverconsumer');
		$this->setPackage('plugins.sfOuathPropelServerPlugin.lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('sfOauthServerConsumer_id_seq');
		// columns
		$this->addColumn('CONSUMER_KEY', 'ConsumerKey', 'VARCHAR', true, 40, null);
		$this->addColumn('CONSUMER_SECRET', 'ConsumerSecret', 'VARCHAR', true, 40, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 256, null);
		$this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', true, null, null);
		$this->addColumn('PROTOCOLE', 'Protocole', 'INTEGER', false, null, 1);
		$this->addColumn('BASE_DOMAIN', 'BaseDomain', 'VARCHAR', false, 256, null);
		$this->addColumn('CALLBACK', 'Callback', 'VARCHAR', false, 256, null);
		$this->addColumn('SCOPE', 'Scope', 'VARCHAR', false, 256, null);
		$this->addColumn('NUMBER_QUERY', 'NumberQuery', 'INTEGER', false, null, 0);
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('Sfoauthserverdeveloper', 'Sfoauthserverdeveloper', RelationMap::ONE_TO_MANY, array('id' => 'consumer_id', ), null, null, 'Sfoauthserverdevelopers');
		$this->addRelation('Sfoauthserverrequesttoken', 'Sfoauthserverrequesttoken', RelationMap::ONE_TO_MANY, array('id' => 'consumer_id', ), null, null, 'Sfoauthserverrequesttokens');
		$this->addRelation('Sfoauthserveraccesstoken', 'Sfoauthserveraccesstoken', RelationMap::ONE_TO_MANY, array('id' => 'consumer_id', ), null, null, 'Sfoauthserveraccesstokens');
		$this->addRelation('Sfoauthserveruserscope', 'Sfoauthserveruserscope', RelationMap::ONE_TO_MANY, array('id' => 'consumer_id', ), null, null, 'Sfoauthserveruserscopes');
	} // buildRelations()

	/**
	 *
	 * Gets the list of behaviors registered for this table
	 *
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // SfoauthserverconsumerTableMap
