<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Request {
	private $method;
	private $host;
	private $uri;

	/**
	 *
	 */
	public function __construct($method, $host, $uri) {
		$this->method = strtolower($method);
		$this->host = preg_replace("([^a-zA-Z0-9\-\.])", "", $host);
		$this->uri = $uri;
	}

	/**
	 *
	 */
	public function getMethod() {
		return $this->method;
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
	public function getUri() {
		return $this->uri;
	}
}

?>