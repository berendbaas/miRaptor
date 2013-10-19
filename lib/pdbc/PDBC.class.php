<?php
namespace lib\pdbc;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
interface PDBC {
	/**
	 * Construct a PDBC object. A database connection is made with the given hostname, username & password.
	 * 
	 * @param  String $hostname
	 * @param  String $username
	 * @param  String $password
	 * @throws Exception on failure.
	 */
	public function __construct($hostname, $username, $password);

	/**
	 * Clone is ought to return a deep copy of the PDBC object.
	 */
	public function __clone();

	/**
	 * Try to select the given database.
	 *
	 * @param  String $database
	 * @return void
	 * @throws Exception on failure.
	 */
	public function selectDatabase($database);

	/**
	 * Returns a quoted string that is safe to pass into an SQL statement.
	 *
	 * @param  String $string
	 * @return String a quoted string that is safe to pass into an SQL statement.
	 * @throws Exception on failure.
	 */
	public function quote($string);

	/**
	 * Try to execute the given query.
	 *
	 * @param  String $query
	 * @return void
	 * @throws Exception on failure.
	 */
	public function query($query);

	/**
	 * Returns an array indexed by column name as returned in your result set.
	 *
	 * @return Array an array indexed by column name as returned in your result set.
	 * @throws Exception on failure.
	 */
	public function fetch();

	/**
	 * Returns an array containing all remaining rows indexed by column name as returned in your result set.
	 *
	 * @return Array an array containing all remaining rows indexed by column name as returned in your result set.
	 * @throws Exception on failure.
	 */
	public function fetchAll();

	/**
	 * Returns the number of rows.
	 *
	 * @returns int the number of rows.
	 */
	public function rowCount();
}

?>
