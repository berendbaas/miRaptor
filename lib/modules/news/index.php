<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class News implements Module {
	private $args;
	private $page;
	private $pdbc;

	public function __construct(array $args, $page, PDBC $pdbc) {
		$this->args = $args;
		$this->page = $page;
		$this->pdbc = $pdbc;
	}

	public function isStatic() {
		return FALSE;
	}

	public function get() {
/*
		$query = 'SELECT `id` FROM `module_news_category` WHERE `name` = ' . mysql_;
		$query = 

		$this->pdbc->fetch($query);
*/
	}
}

?>
