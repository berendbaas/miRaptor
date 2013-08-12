<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class MenuAdmin implements AdminInterface {
	private $mysql;

	/**
	 *
	 */
	public function __construct($mysql) {
		$this->mysql = $mysql;
	}

	/**
	 *
	 */
	public function get() {
		return '<p>Menu Admin</p>'
	}
}

?>