<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class MediaAdmin implements AdminInterface {
	private $base_url;
	private $base_url_parameters;
	private $mysql;

	/**
	 *
	 */
	public function __construct($base_url, $base_url_parameters, $mysql) {
		#this->base_url = $base_url;
		#this->base_url_parameters = $base_url_parameters;
		$this->mysql = $mysql;
	}

	/**
	 *
	 */
	public function get() {
		return '<p>Media Admin</p>'
	}
}

?>