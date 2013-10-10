<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class URL {
	const DELIMITER_SCHEME = '://';
	const DELIMITER_QUERY = '?';

	private $scheme;
	private $host;
	private $directory;
	private $file;
	private $query;

	/**
	 *
	 */
	public function __construct($scheme, $host, $uri) {
		// Split path and query and determine file position.
		$uri = explode(self::DELIMITER_QUERY, $uri, 2);
		$pos = strrpos($uri[0], '/') + 1;

		// Set scheme, host, directory, file & query
		$this->scheme = $scheme;
		$this->host = preg_replace("([^a-zA-Z0-9\-\.])", "", $host);
		$this->directory = substr($uri[0], 0, $pos);
		$this->file = strlen($uri[0]) > $pos ? substr($uri[0], $pos) : '';
		$this->query = (isset($uri[1]) ? $uri[1] : '');
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->getURL();
	}

	/**
	 *
	 */
	public function getURL() {
		return $this->scheme . self::DELIMITER_SCHEME . $this->host . $this->getURI();
	}

	/**
	 *
	 */
	public function getURLBase() {
		return $this->scheme . self::DELIMITER_SCHEME . $this->host . $this->directory;
	}

	/**
	 *
	 */
	public function getURI() {
		return $this->getPath() . self::DELIMITER_QUERY . $this->query;
	}

	/**
	 *
	 */
	public function getPath() {
		return $this->directory . $this->file;
	}

	/**
	 *
	 */
	public function getScheme() {
		return $this->scheme;
	}

	/**
	 *
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 *
	 */
	public function getDirectory() {
		return $this->directory;
	}

	/**
	 *
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 *
	 */
	public function getQuery() {
		return $this->query;
	}
}

?>
