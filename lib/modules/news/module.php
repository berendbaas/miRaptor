<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class News implements ModuleInterface {
	private $pdbc;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->page = $page;
		$this->args = $args;
		$this->result = '';
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->result;
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
	public function run() {
/*
		$query = 'SELECT `id`FROM `module_news_category` WHERE `name` = ' . mysql_;
		$query = 

		$this->pdbc->fetch($query);
*/
	}
}

?>
