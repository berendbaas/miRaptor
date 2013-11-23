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

	public function __construct($hostname, $username, $password) {
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;

		if(!($this->link = mysql_connect($hostname, $username, $password, TRUE))) {
			throw new PDBCException('Mysql: Can\'t connect to database - ' . $hostname);
		}
	}

	public function __clone() {
		if(!($this->link = mysql_connect($this->hostname, $this->username, $this->password, TRUE))) {
			throw new PDBCException('Mysql: Can\'t connect to database - ' . $this->hostname);
		}

		if(isset($this->database)) {
			if(!mysql_select_db($this->database, $this->link)) {
				throw new PDBCException('Mysql: Can\'t select database - ' . $this->database);
			}
		}
	}

	public function selectDatabase($database) {
		$this->database = $database;

		if(!mysql_select_db($database, $this->link)) {
			throw new PDBCException('Mysql: Can\'t select database - ' . $database);
		}
	}

	public function quote($string) {
		$result = mysql_real_escape_string($string);

		if($result === FALSE) {
			throw new PDBCException('Mysql: Can\'t quote - ' . $string);
		}

		return $result;
	}

	public function query($query) {
		$this->resource = mysql_query($query, $this->link);

		if(!$this->resource) {
			throw new PDBCException('Mysql: Can\'t execute query - ' . $query);
		}

		return $this;
	}

	public function fetch() {
		$row = mysql_fetch_assoc($this->resource);

		return !$row ? array() : $row;
	}

	public function fetchAll() {
		$rows = array();

		while($row = $this->fetch()) {
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
}

?>
