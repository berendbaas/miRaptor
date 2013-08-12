<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class URI {
	const QUERY_DELIMITER = '?';
	const QUERY_SEPARATOR = '&';
	const QUERY_KEY_VALUE = '=';

	private $path;
	private $query;

	/**
	 *
	 */
	public function __construct($uri) {
		// Split path and query
		$uri = explode(self::QUERY_DELIMITER, $uri, 2);

		// Set path and query
		$this->path = $uri[0];
		$this->query = empty($uri[1]) ? NULL : $uri[1];
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->path . $this->query;
	}

	/**
	 *
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 *
	 */
	public function addQuery($key, $value) {
		$this->query .= (($this->query == NULL) ? self::QUERY_DELIMITER : self::QUERY_SEPARATOR) . $key . self::QUERY_KEY_VALUE . $value;
	}

	/**
	 *
	 */
	public function getQuery() {
		return $this->query;
	}
}

?>