<?php
namespace lib\pdbc;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Mysql implements PDBC {
	private $hostname;
	private $username;
	private $password;
	private $database;

	private $link;
	private $resource;

	public function __construct($hostname, $username, $password, $database = '') {
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;

		$this->mysqlConnect();
		$this->mysqlSelectDatabase();
	}

	public function __clone() {
		$this->mysqlConnect();
		$this->mysqlSelectDatabase();
	}

	public function selectDatabase($database) {
		$this->database = $database;

		$this->mysqlSelectDatabase();
	}

	public function quote($string) {
		$result = mysql_real_escape_string($string, $this->link);

		if($result === FALSE) {
			throw new PDBCException('Mysql(' . mysql_errno($this->link) . '): ' . mysql_error($this->link));
		}

		return $result;
	}

	public function query($query) {
		$this->resource = mysql_query($query, $this->link);

		if($this->resource === FALSE) {
			throw new PDBCException('Mysql(' . mysql_errno($this->link) . '): ' . mysql_error($this->link));
		}

		return $this;
	}

	public function fetch() {
		$row = mysql_fetch_assoc($this->resource);

		return $row === FALSE ? NULL : $row;
	}

	public function fetchAll() {
		$rows = array();

		while(($row = $this->fetch()) !== NULL) {
			$rows[] = $row;
		}

		return $rows;
	}

	public function rowCount() {
		return mysql_affected_rows($this->link);
	}

	public function insertID() {
		return mysql_insert_id($this->link);
	}

	/**
	 * Connect with the Mysql database.
	 *
	 * @return void
	 */
	private function mysqlConnect() {
		if(!($this->link = mysql_connect($this->hostname, $this->username, $this->password, TRUE))) {
			throw new PDBCException('Mysql(' . mysql_errno($this->link) . '): ' . mysql_error($this->link));
		}
	}

	/**
	 * Select the current Mysql database.
	 *
	 * @return void
	 */
	private function mysqlSelectDatabase() {
		if($this->database !== '' && !mysql_select_db($this->database, $this->link)) {
			throw new PDBCException('Mysql(' . mysql_errno($this->link) . '): ' . mysql_error($this->link));
		}
	}
}

?>
