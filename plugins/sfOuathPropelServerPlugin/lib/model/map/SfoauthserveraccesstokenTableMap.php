<?php



/**
 * This class defines the structure of the 'sfOauthServerAccessToken' table.
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
class SfoauthserveraccesstokenTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfOuathPropelServerPlugin.lib.model.map.SfoauthserveraccesstokenTableMap';

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
		$this->setName('sfOauthServerAccessToken');
		$this->setPhpName('Sfoauthserveraccesstoken');
		$this->setClassname('Sfoauthserveraccesstoken');
		$this->setPackage('plugins.sfOuathPropelServerPlugin.lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('sfOauthServerAccessToken_id_seq');
		// columns
		$this->addColumn('TOKEN', 'Token', 'VARCHAR', true, 40, null);
		$this->addColumn('SECRET', 'Secret', 'VARCHAR', false, 40, null);
		$this->addForeignKey('CONSUMER_ID', 'ConsumerId', 'INTEGER', 'sfOauthServerConsumer', 'ID', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user', 'ID', false, null, null);
		$this->addColumn('SCOPE', 'Scope', 'VARCHAR', false, 256, null);
		$this->addColumn('EXPIRES', 'Expires', 'INTEGER', false, null, null);
		$this->addColumn('PROTOCOLE', 'Protocole', 'INTEGER', false, null, 1);
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('Sfoauthserverconsumer', 'Sfoauthserverconsumer', RelationMap::MANY_TO_ONE, array('consumer_id' => 'id', ), null, null);
		$this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
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
			'symfony' => array('form' => 'false', 'filter' => 'false', ),
			'timestampable' => array('create_column' => 'created_at', 'update_column' => 'created_at', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // SfoauthserveraccesstokenTableMap
