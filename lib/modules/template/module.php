<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Template implements Module {
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
		return TRUE;
	}

	/**
	 *
	 */
	public function get() {
		$result = $this->pdbc->fetch('SELECT `content`
		                              FROM `module_template`
		                              WHERE `id` = (SELECT `tid`
		                                            FROM `pages`
		                                            WHERE `id` = "' . $this->pdbc->quote($this->page) . '")');

		if(empty($result)) {
			throw new Exception('Template does not exists.');
		}

		return end(end($result));
	}
}

?>