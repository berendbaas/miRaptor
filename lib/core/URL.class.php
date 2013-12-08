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
	 * Construct a URL object with the given scheme, host & URI.
	 *
	 * @param string $scheme
	 * @param string $host
	 * @param string $uri
	 */
	public function __construct($scheme, $host, $uri) {
		// Set scheme & host.
		$this->scheme = $scheme;
		$this->host = $host;

		// Split URI in directory, file and query.
		$uri = explode(self::DELIMITER_QUERY, $uri, 2);
		$pos = strrpos($uri[0], '/') + 1;

		// Set directory, file & query.
		$this->directory = substr($uri[0], 0, $pos);
		$this->file = strlen($uri[0]) > $pos ? substr($uri[0], $pos) : '';
		$this->query = (isset($uri[1]) ? $uri[1] : '');
	}

	/**
	 * Returns a string representation of the URL object.
	 *
	 * scheme + DELIMITER_SCHEME + host + directory + file + DELIMITER_QUERY + query
	 *
	 * @return string a string representation of the URL object.
	 */
	public function __toString() {
		return $this->getURL();
	}

	/**
	 * Returns the URL.
	 *
	 * scheme + DELIMITER_SCHEME + host + directory + file + DELIMITER_QUERY + query
	 *
	 * @return string the URL.
	 */
	public function getURL() {
		return $this->getURLHost() . $this->getURI();
	}

	/**
	 * Returns the URL scheme, host & path.
	 *
	 * scheme + DELIMITER_SCHEME + host + directory + file
	 * 
	 * @return string the URL scheme, host & path.
	 */
	public function getURLPath() {
		return $this->getURLHost() . $this->getPath();
	}

	/**
	 * Returns the URL scheme, host & directory.
	 *
	 * scheme + DELIMITER_SCHEME + host + directory
	 *
	 * @return string the URL scheme, host & directory.
	 */
	public function getURLDirectory() {
		return $this->getURLHost() . $this->directory;
	}

	/**
	 * Returns the URL scheme, host.
	 *
	 * scheme + DELIMITER_SCHEME + host
	 *
	 * @return string the URL scheme, host.
	 */
	public function getURLHost() {
		return ($this->scheme === '' ? '' : $this->scheme . self::DELIMITER_SCHEME) . $this->host;
	}

	/**
	 * Returns the URI.
	 *
	 * directory + file + DELIMITER_QUERY + query
	 *
	 * @return string the URI.
	 */
	public function getURI() {
		return $this->getPath() . ($this->query === '' ? '' : self::DELIMITER_QUERY . $this->query);
	}

	/**
	 * Returns the path.
	 *
	 * directory + file
	 *
	 * @return string the path.
	 */
	public function getPath() {
		return $this->directory . $this->file;
	}

	/**
	 * Returns the scheme.
	 *
	 * @return string the scheme.
	 */
	public function getScheme() {
		return $this->scheme;
	}

	/**
	 * Returns the host.
	 *
	 * @return string the host.
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * Returns the directory.
	 *
	 * @return string the directory.
	 */
	public function getDirectory() {
		return $this->directory;
	}

	/**
	 * Returns the file.
	 *
	 * @return string the file.
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Returns the query.
	 *
	 * @return string the query.
	 */
	public function getQuery() {
		return $this->query;
	}
}

?>
