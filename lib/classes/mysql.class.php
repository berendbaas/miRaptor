<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Mysql implements PDBC {
	private $link;

	/**
	 *
	 */
	public function __construct(array $config) {
		if(!($this->link = mysql_connect($config['hostname'], $config['username'], $config['password'], TRUE))) {
			throw new Exception('Mysql: Can\'t connect to database - ' . $config['hostname'], 500);
		}
	}

	/**
	 *
	 */
	public function selectDatabase($database) {
		if(!mysql_select_db($database, $this->link)) {
			throw new Exception('Mysql: Can\'t select database - ' . $database, 500);
		}
	}

	/**
	 *
	 */
	public function execute($query) {
		$resource = mysql_query($query, $this->link);

		if(!$resource) {
			throw new Exception('Mysql: Can\'t execute query - ' . mysql_error(), 500);
		}

		return $resource;
	}

	/**
	 *
	 */
	public function fetch($query) {
		$resource = $this->execute($query);

		$rows = array();

		while($row = mysql_fetch_assoc($resource)) {
			$rows[] = $row;
		}

		return $rows;
	}

	/**
	 *
	 */
	public function quote($string) {
		return mysql_real_escape_string($string);
	}
}

?>
