<?php
namespace lib\pdbc;

/**
* @author miWebb <info@miwebb.com>
* @copyright Copyright (c) 2013, miWebb
* @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
* @version 1.0
*/
class Mysqli implements PDBC {
	private $hostname;
	private $username;
	private $password;
	private $database;

	private $mysqli;
	private $result;

	public function __construct($hostname, $username, $password, $database = '') {
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;

		$this->mysqli = new \Mysqli($this->hostname, $this->username, $this->password, $this->database);

		if($this->mysqli->connect_errno) {
			throw new PDBCException('Mysqli(' . $this->mysqli->connect_errno . '): ' . $this->mysqli->connect_error);
		}
	}

	public function __clone() {
		$this->mysqli = new \Mysqli($this->hostname, $this->username, $this->password, $this->database);

		if($this->mysqli->errno) {
			throw new PDBCException('Mysqli(' . $this->mysqli->errno . '): ' . $this->mysqli->error);
		}
	}

	public function selectDatabase($database) {
		$this->database = $database;

		if(!$this->mysqli->select_db($database)) {
			throw new PDBCException('Mysqli(' . $this->mysqli->errno . '): ' . $this->mysqli->error);
		}
	}
	
	public function transactionBegin() {
		$this->mysqli->autocommit(FALSE);
	}

	public function transactionCommit() {
		$this->mysqli->commit();
	}

	public function transactionRollBack() {
		$this->mysqli->rollback();
	}

	public function quote($string) {
		return $this->mysqli->real_escape_string($string);
	}

	public function query($query) {
		$this->result = $this->mysqli->query($query);

		if($this->result === FALSE) {
			throw new PDBCException('Mysqli(' . $this->mysqli->errno . '): ' . $this->mysqli->error);
		}

		return $this;
	}

	public function fetch() {
		return $this->result->fetch_assoc();
	}

	public function fetchAll() {
		$rows = array();

		while(($row = $this->fetch()) !== NULL) {
			$rows[] = $row;
		}

		return $rows;
	}

	public function rowCount() {
		return $this->mysqli->affected_rows;
	}

	public function insertID() {
		return $this->mysqli->insert_id;
	}
}

?>