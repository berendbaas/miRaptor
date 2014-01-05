<?php
namespace lib\util;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class URL {
	const DELIMITER_SCHEME = '://';
	const DELIMITER_SEGMENT = '/';
	const DELIMITER_QUERY = '?';
	const DELIMITER_QUERY_PAIR = '&';
	const DELIMITER_QUERY_KEY_VALUE = '=';
	const DELIMITER_FRAGMENT = '#';

	private $scheme;
	private $host;
	private $path;
	private $query;
	private $fragment;

	/**
	 * Construct a URL object with the given URL.
	 *
	 * @param string $url
	 */
	public function __construct($url) {
		// Parse URL components
		$component = parse_url($url);

		// Set URL components
		$this->scheme = isset($component['scheme']) ? $component['scheme'] : '';
		$this->host = isset($component['host']) ? $component['host'] : '';
		$this->path = isset($component['path']) ? $component['path'] : '';
		$this->query = isset($component['query']) ? $component['query'] : '';
		$this->fragment = isset($component['fragment']) ? $component['fragment'] : '';
	}

	/**
	 * Returns a string representation of the URL object.
	 *
	 * scheme + DELIMITER_SCHEME + host + path + DELIMITER_QUERY + query
	 *
	 * @return string a string representation of the URL object.
	 */
	public function __toString() {
		return $this->getURL();
	}

	/**
	 * Returns the URL.
	 *
	 * scheme + DELIMITER_SCHEME + host + path + DELIMITER_QUERY + query + DELIMITER_FRAGMENT + fragment
	 *
	 * @return string the URL.
	 */
	public function getURL() {
		return $this->getURLHost() . $this->getURI();
	}

	/**
	 * Returns the URL scheme, host, path & query.
	 *
	 * scheme + DELIMITER_SCHEME + host + path + DELIMITER_QUERY + query
	 *
	 * @return string the URL.
	 */
	public function getURLQuery() {
		return $this->getURLHost() . $this->getPath() . ($this->query === '' ? '' : self::DELIMITER_QUERY . $this->query);
	}

	/**
	 * Returns the URL scheme, host & path.
	 *
	 * scheme + DELIMITER_SCHEME + host + path
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
		return $this->getURLHost() . $this->getDirectory();
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
	 * Returns the URI.
	 *
	 * path + DELIMITER_QUERY + query + DELIMITER_FRAGMENT + fragment
	 *
	 * @return string the URI.
	 */
	public function getURI() {
		return $this->getPath() . ($this->query === '' ? '' : self::DELIMITER_QUERY . $this->query) . ($this->fragment === '' ? '' : self::DELIMITER_FRAGMENT . $this->fragment);
	}

	/**
	 * Returns the path.
	 *
	 * @return string the path.
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Returns the directory.
	 *
	 * @return string the directory.
	 */
	public function getDirectory() {
		return substr($this->path, -1) === self::DELIMITER_SEGMENT ? $this->path : dirname($this->path) . self::DELIMITER_SEGMENT;
	}

	/**
	 * Returns the file.
	 *
	 * @return string the file.
	 */
	public function getFile() {
		return substr($this->path, -1) === self::DELIMITER_SEGMENT ? '' : basename($this->path);
	}

	/**
	 * Returns the query.
	 *
	 * @return string the query.
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * Returns the fragment.
	 *
	 * @return string the fragment.
	 */
	public function getFragment() {
		return $this->fragment;
	}

	/**
	 * Set the scheme.
	 *
	 * @param  string $scheme
	 * @return void
	 */
	public function setScheme($scheme) {
		$this->scheme = $scheme;
	}

	/**
	 * Set the host.
	 *
	 * @param  string $host
	 * @return void
	 */
	public function setHost($host) {
		$this->host = $host;
	}

	/**
	 * Set the path.
	 *
	 * @param  string $path
	 * @return void
	 */
	public function setPath($path) {
		$this->path = $path;
	}

	/**
	 * Set the query
	 *
	 * @param  array   $query
	 * @param  boolean $encode = FALSE
	 * @return void
	 */
	public function buildQuery(array $query, $encode = FALSE) {
		// Build
		$this->query = http_build_query($query);

		// Encode
		if($encode) $this->query = htmlentities($this->query);
	}

	/**
	 * Set the query.
	 *
	 * @param  string $query
	 * @return void
	 */
	public function setQuery($query) {
		$this->query = $query;
	}

	/**
	 * Set the fragment.
	 *
	 * @param  string $fragment
	 * @return void
	 */
	public function setFragment($fragment) {
		$this->fragment = $fragment;
	}

	/**
	 * Returns the URL segements
	 *
	 * @return array the URL segments
	 */
	public function getSegments() {
		return explode(self::DELIMITER_SEGMENT, substr($directory, strlen(self::DELIMITER_SEGMENT), -strlen(self::DELIMITER_SEGMENT)));
	}
}

?>
