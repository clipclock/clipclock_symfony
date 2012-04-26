<?php



/**
 * This class defines the structure of the 'sfOauthServerDeveloper' table.
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
class SfoauthserverdeveloperTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfOuathPropelServerPlugin.lib.model.map.SfoauthserverdeveloperTableMap';

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
		$this->setName('sfOauthServerDeveloper');
		$this->setPhpName('Sfoauthserverdeveloper');
		$this->setClassname('Sfoauthserverdeveloper');
		$this->setPackage('plugins.sfOuathPropelServerPlugin.lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('sfOauthServerDeveloper_id_seq');
		// columns
		$this->addForeignKey('CONSUMER_ID', 'ConsumerId', 'INTEGER', 'sfOauthServerConsumer', 'ID', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user', 'ID', true, null, null);
		$this->addColumn('ADMIN', 'Admin', 'BOOLEAN', false, null, false);
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
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
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // SfoauthserverdeveloperTableMap
