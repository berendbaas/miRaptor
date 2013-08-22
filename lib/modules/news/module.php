<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class News implements Module {
	private $pdbc;
	private $page;
	private $args;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->page = $page;
		$this->args = $args;
	}

	/**
	 *
	 */
	public function isStatic() {
		return FALSE;
	}

	/**
	 *
	 */
	public function get() {
/*
		$query = 'SELECT `id`FROM `module_news_category` WHERE `name` = ' . mysql_;
		$query = 

		$this->pdbc->fetch($query);
*/
	}
}

?>
