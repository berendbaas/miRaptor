<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Template implements \ModuleInterface {
	private $pdbc;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(\PDBC $pdbc, $page, array $args) {
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
		return TRUE;
	}

	/**
	 *
	 */
	public function run() {
		$result = $this->pdbc->fetch('SELECT `content`
		                              FROM `module_template`
		                              WHERE `id` = (SELECT `tid`
		                                            FROM `pages`
		                                            WHERE `id` = "' . $this->pdbc->quote($this->page) . '")');

		if(empty($result)) {
			throw new Exception('Template does not exists.');
		}

		$this->result = end(end($result));
	}
}

?>