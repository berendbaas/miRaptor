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
	 * @param  String        $hostname
	 * @param  String        $username
	 * @param  String        $password
	 * @throws PDBCException if you can't connected to the database with the given credentials.
	 */
	public function __construct($hostname, $username, $password);

	/**
	 * Clone is ought to return a deep copy of the PDBC object.
	 */
	public function __clone();

	/**
	 * Try to select the given database.
	 *
	 * @param  String        $database
	 * @return void
	 * @throws PDBCException if the given database can't select the database.
	 */
	public function selectDatabase($database);

	/**
	 * Returns a quoted string that is safe to pass into an SQL statement.
	 *
	 * @param  String        $string
	 * @return String        a quoted string that is safe to pass into an SQL statement.
	 * @throws PDBCException if the given string can't be quoted.
	 */
	public function quote($string);

	/**
	 * Returns this object and executes the given query.
	 *
	 * @param  String        $query
	 * @return PDBC          this object and executes the given query.
	 * @throws PDBCException if the given query can't be executed.
	 */
	public function query($query);

	/**
	 * Returns an array indexed by column name or an empty array there is nothing to fetch.
	 *
	 * @return Array an array indexed by column name or an empty array there is nothing to fetch.
	 */
	public function fetch();

	/**
	 * Returns an array containing all remaining rows indexed by column name or an empty array there is nothing to fetch.
	 *
	 * @return Array an array containing all remaining rows indexed by column name or an empty array there is nothing to fetch.
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
