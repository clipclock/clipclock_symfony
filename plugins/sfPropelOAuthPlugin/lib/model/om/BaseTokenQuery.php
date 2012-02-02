<?php


/**
 * Base class that represents a query for the 'token' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.3 on:
 *
 * Thu Feb  2 04:58:14 2012
 *
 * @method     TokenQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     TokenQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     TokenQuery orderByTokenKey($order = Criteria::ASC) Order by the token_key column
 * @method     TokenQuery orderByTokenSecret($order = Criteria::ASC) Order by the token_secret column
 * @method     TokenQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     TokenQuery orderByExpire($order = Criteria::ASC) Order by the expire column
 * @method     TokenQuery orderByParams($order = Criteria::ASC) Order by the params column
 * @method     TokenQuery orderByIdentifier($order = Criteria::ASC) Order by the identifier column
 * @method     TokenQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     TokenQuery orderByOAuthVersion($order = Criteria::ASC) Order by the o_auth_version column
 * @method     TokenQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     TokenQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     TokenQuery groupById() Group by the id column
 * @method     TokenQuery groupByName() Group by the name column
 * @method     TokenQuery groupByTokenKey() Group by the token_key column
 * @method     TokenQuery groupByTokenSecret() Group by the token_secret column
 * @method     TokenQuery groupByUserId() Group by the user_id column
 * @method     TokenQuery groupByExpire() Group by the expire column
 * @method     TokenQuery groupByParams() Group by the params column
 * @method     TokenQuery groupByIdentifier() Group by the identifier column
 * @method     TokenQuery groupByStatus() Group by the status column
 * @method     TokenQuery groupByOAuthVersion() Group by the o_auth_version column
 * @method     TokenQuery groupByCreatedAt() Group by the created_at column
 * @method     TokenQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     TokenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     TokenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     TokenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     TokenQuery leftJoinsfGuardUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the sfGuardUser relation
 * @method     TokenQuery rightJoinsfGuardUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the sfGuardUser relation
 * @method     TokenQuery innerJoinsfGuardUser($relationAlias = null) Adds a INNER JOIN clause to the query using the sfGuardUser relation
 *
 * @method     Token findOne(PropelPDO $con = null) Return the first Token matching the query
 * @method     Token findOneOrCreate(PropelPDO $con = null) Return the first Token matching the query, or a new Token object populated from the query conditions when no match is found
 *
 * @method     Token findOneById(int $id) Return the first Token filtered by the id column
 * @method     Token findOneByName(string $name) Return the first Token filtered by the name column
 * @method     Token findOneByTokenKey(string $token_key) Return the first Token filtered by the token_key column
 * @method     Token findOneByTokenSecret(string $token_secret) Return the first Token filtered by the token_secret column
 * @method     Token findOneByUserId(int $user_id) Return the first Token filtered by the user_id column
 * @method     Token findOneByExpire(int $expire) Return the first Token filtered by the expire column
 * @method     Token findOneByParams(string $params) Return the first Token filtered by the params column
 * @method     Token findOneByIdentifier(string $identifier) Return the first Token filtered by the identifier column
 * @method     Token findOneByStatus(string $status) Return the first Token filtered by the status column
 * @method     Token findOneByOAuthVersion(int $o_auth_version) Return the first Token filtered by the o_auth_version column
 * @method     Token findOneByCreatedAt(string $created_at) Return the first Token filtered by the created_at column
 * @method     Token findOneByUpdatedAt(string $updated_at) Return the first Token filtered by the updated_at column
 *
 * @method     array findById(int $id) Return Token objects filtered by the id column
 * @method     array findByName(string $name) Return Token objects filtered by the name column
 * @method     array findByTokenKey(string $token_key) Return Token objects filtered by the token_key column
 * @method     array findByTokenSecret(string $token_secret) Return Token objects filtered by the token_secret column
 * @method     array findByUserId(int $user_id) Return Token objects filtered by the user_id column
 * @method     array findByExpire(int $expire) Return Token objects filtered by the expire column
 * @method     array findByParams(string $params) Return Token objects filtered by the params column
 * @method     array findByIdentifier(string $identifier) Return Token objects filtered by the identifier column
 * @method     array findByStatus(string $status) Return Token objects filtered by the status column
 * @method     array findByOAuthVersion(int $o_auth_version) Return Token objects filtered by the o_auth_version column
 * @method     array findByCreatedAt(string $created_at) Return Token objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Token objects filtered by the updated_at column
 *
 * @package    propel.generator.plugins.sfPropelOAuthPlugin.lib.model.om
 */
abstract class BaseTokenQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseTokenQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'Token', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new TokenQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    TokenQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof TokenQuery) {
			return $criteria;
		}
		$query = new TokenQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key.
	 * Propel uses the instance pool to skip the database if the object exists.
	 * Go fast if the query is untouched.
	 *
	 * <code>
	 * $obj = $c->findPk(array(12, 34), $con);
	 * </code>
	 *
	 * @param     array[$id, $user_id] $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    Token|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = TokenPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(TokenPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		if ($this->formatter || $this->modelAlias || $this->with || $this->select
		 || $this->selectColumns || $this->asColumns || $this->selectModifiers
		 || $this->map || $this->having || $this->joins) {
			return $this->findPkComplex($key, $con);
		} else {
			return $this->findPkSimple($key, $con);
		}
	}

	/**
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    Token A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT ID, NAME, TOKEN_KEY, TOKEN_SECRET, USER_ID, EXPIRE, PARAMS, IDENTIFIER, STATUS, O_AUTH_VERSION, CREATED_AT, UPDATED_AT FROM token WHERE ID = :p0 AND USER_ID = :p1';
		try {
			$stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
			$stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new Token();
			$obj->hydrate($row);
			TokenPeer::addInstanceToPool($obj, serialize(array((string) $row[0], (string) $row[1])));
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    Token|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		$this->addUsingAlias(TokenPeer::ID, $key[0], Criteria::EQUAL);
		$this->addUsingAlias(TokenPeer::USER_ID, $key[1], Criteria::EQUAL);

		return $this;
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		if (empty($keys)) {
			return $this->add(null, '1<>1', Criteria::CUSTOM);
		}
		foreach ($keys as $key) {
			$cton0 = $this->getNewCriterion(TokenPeer::ID, $key[0], Criteria::EQUAL);
			$cton1 = $this->getNewCriterion(TokenPeer::USER_ID, $key[1], Criteria::EQUAL);
			$cton0->addAnd($cton1);
			$this->addOr($cton0);
		}

		return $this;
	}

	/**
	 * Filter the query on the id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(TokenPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
	 * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $name The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($name)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $name)) {
				$name = str_replace('*', '%', $name);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TokenPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the token_key column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTokenKey('fooValue');   // WHERE token_key = 'fooValue'
	 * $query->filterByTokenKey('%fooValue%'); // WHERE token_key LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $tokenKey The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByTokenKey($tokenKey = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($tokenKey)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $tokenKey)) {
				$tokenKey = str_replace('*', '%', $tokenKey);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TokenPeer::TOKEN_KEY, $tokenKey, $comparison);
	}

	/**
	 * Filter the query on the token_secret column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTokenSecret('fooValue');   // WHERE token_secret = 'fooValue'
	 * $query->filterByTokenSecret('%fooValue%'); // WHERE token_secret LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $tokenSecret The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByTokenSecret($tokenSecret = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($tokenSecret)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $tokenSecret)) {
				$tokenSecret = str_replace('*', '%', $tokenSecret);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TokenPeer::TOKEN_SECRET, $tokenSecret, $comparison);
	}

	/**
	 * Filter the query on the user_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUserId(1234); // WHERE user_id = 1234
	 * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
	 * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
	 * </code>
	 *
	 * @see       filterBysfGuardUser()
	 *
	 * @param     mixed $userId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByUserId($userId = null, $comparison = null)
	{
		if (is_array($userId) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(TokenPeer::USER_ID, $userId, $comparison);
	}

	/**
	 * Filter the query on the expire column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByExpire(1234); // WHERE expire = 1234
	 * $query->filterByExpire(array(12, 34)); // WHERE expire IN (12, 34)
	 * $query->filterByExpire(array('min' => 12)); // WHERE expire > 12
	 * </code>
	 *
	 * @param     mixed $expire The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByExpire($expire = null, $comparison = null)
	{
		if (is_array($expire)) {
			$useMinMax = false;
			if (isset($expire['min'])) {
				$this->addUsingAlias(TokenPeer::EXPIRE, $expire['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($expire['max'])) {
				$this->addUsingAlias(TokenPeer::EXPIRE, $expire['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TokenPeer::EXPIRE, $expire, $comparison);
	}

	/**
	 * Filter the query on the params column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByParams('fooValue');   // WHERE params = 'fooValue'
	 * $query->filterByParams('%fooValue%'); // WHERE params LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $params The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByParams($params = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($params)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $params)) {
				$params = str_replace('*', '%', $params);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TokenPeer::PARAMS, $params, $comparison);
	}

	/**
	 * Filter the query on the identifier column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIdentifier('fooValue');   // WHERE identifier = 'fooValue'
	 * $query->filterByIdentifier('%fooValue%'); // WHERE identifier LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $identifier The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByIdentifier($identifier = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($identifier)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $identifier)) {
				$identifier = str_replace('*', '%', $identifier);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TokenPeer::IDENTIFIER, $identifier, $comparison);
	}

	/**
	 * Filter the query on the status column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
	 * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $status The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByStatus($status = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($status)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $status)) {
				$status = str_replace('*', '%', $status);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TokenPeer::STATUS, $status, $comparison);
	}

	/**
	 * Filter the query on the o_auth_version column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByOAuthVersion(1234); // WHERE o_auth_version = 1234
	 * $query->filterByOAuthVersion(array(12, 34)); // WHERE o_auth_version IN (12, 34)
	 * $query->filterByOAuthVersion(array('min' => 12)); // WHERE o_auth_version > 12
	 * </code>
	 *
	 * @param     mixed $oAuthVersion The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByOAuthVersion($oAuthVersion = null, $comparison = null)
	{
		if (is_array($oAuthVersion)) {
			$useMinMax = false;
			if (isset($oAuthVersion['min'])) {
				$this->addUsingAlias(TokenPeer::O_AUTH_VERSION, $oAuthVersion['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($oAuthVersion['max'])) {
				$this->addUsingAlias(TokenPeer::O_AUTH_VERSION, $oAuthVersion['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TokenPeer::O_AUTH_VERSION, $oAuthVersion, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $createdAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(TokenPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(TokenPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TokenPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $updatedAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(TokenPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(TokenPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TokenPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related sfGuardUser object
	 *
	 * @param     sfGuardUser|PropelCollection $sfGuardUser The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function filterBysfGuardUser($sfGuardUser, $comparison = null)
	{
		if ($sfGuardUser instanceof sfGuardUser) {
			return $this
				->addUsingAlias(TokenPeer::USER_ID, $sfGuardUser->getId(), $comparison);
		} elseif ($sfGuardUser instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(TokenPeer::USER_ID, $sfGuardUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterBysfGuardUser() only accepts arguments of type sfGuardUser or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the sfGuardUser relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function joinsfGuardUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('sfGuardUser');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'sfGuardUser');
		}

		return $this;
	}

	/**
	 * Use the sfGuardUser relation sfGuardUser object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    sfGuardUserQuery A secondary query class using the current class as primary query
	 */
	public function usesfGuardUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinsfGuardUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'sfGuardUser', 'sfGuardUserQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Token $token Object to remove from the list of results
	 *
	 * @return    TokenQuery The current query, for fluid interface
	 */
	public function prune($token = null)
	{
		if ($token) {
			$this->addCond('pruneCond0', $this->getAliasedColName(TokenPeer::ID), $token->getId(), Criteria::NOT_EQUAL);
			$this->addCond('pruneCond1', $this->getAliasedColName(TokenPeer::USER_ID), $token->getUserId(), Criteria::NOT_EQUAL);
			$this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
		}

		return $this;
	}

} // BaseTokenQuery