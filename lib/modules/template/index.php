<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Template implements Module {
	private $args;
	private $page;
	private $pdbc;

	public function __construct(array $args, $page, PDBC $pdbc) {
		$this->args = $args;
		$this->page = $page;
		$this->pdbc = $pdbc;
	}

	public function isStatic() {
		return TRUE;
	}

	public function get() {
		$result = $this->pdbc->fetch('SELECT `content` FROM `module_template` WHERE `id` = (SELECT `tid` FROM `pages` WHERE `id` = "' . $this->pdbc->quote($this->page) . '")');

		if(empty($result)) {
			throw new Exception('Template does not exists.');
		}

		return end(end($result));
	}
}

?>