<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class URI {
	const QUERY_DELIMITER = '?';
	const QUERY_SEPARATOR = '&';
	const QUERY_KEY_VALUE = '=';

	private $path;
	private $filename;

	/**
	 *
	 */
	public function __construct($uri) {
		// Split path and query
		$uri = explode(self::QUERY_DELIMITER, $uri, 2);

		// Set path and file
		$pos = strrpos($uri[0], '/') + 1;
		$this->path = substr($uri[0], 0, $pos);
		$this->filename = strlen($uri[0]) > $pos ? substr($uri[0], $pos) : '';
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->path . $this->filename . $this->query;
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
	public function getFilename() {
		return $this->filename;
	}
}

?>
