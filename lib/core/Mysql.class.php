<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Mysql implements PDBC {
	private $link;
	private $resource;

	/**
	 *
	 */
	public function __construct(array $config) {
		if(!($this->link = mysql_connect($config['hostname'], $config['username'], $config['password'], TRUE))) {
			throw new \Exception('Mysql: Can\'t connect to database - ' . $config['hostname'], 500);
		}
	}

	/**
	 *
	 */
	public function selectDatabase($database) {
		if(!mysql_select_db($database, $this->link)) {
			throw new \Exception('Mysql: Can\'t select database - ' . $database, 500);
		}
	}

	/**
	 *
	 */
	public function quote($string) {
		return mysql_real_escape_string($string);
	}

	/**
	 *
	 */
	public function query($query) {
		$this->resource = mysql_query($query, $this->link);

		if(!$this->resource) {
			throw new \Exception('Mysql: Can\'t execute query - ' . $query, 500);
		}
	}

	/**
	 *
	 */
	public function fetch() {
		return mysql_fetch_assoc($this->resource);
	}

	/**
	 *
	 */
	public function fetchAll() {
		$rows = array();

		while($row = $this->fetch()) {
			$rows[] = $row;
		}

		return !$rows ? FALSE : $rows;
	}

	/**
	 *
	 */
	public function rowCount() {
		return mysql_affected_rows($this->link);
	}
}

?>
