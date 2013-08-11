<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Breadcrumb implements Module {
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
		return '<ul>' . $this->parseBreadcrumb($this->page) . '</ul>';
	}

	private function parseId() {
		if(isset($this->args['id'])) {
			return intval($this->args['id']);
		}

		return 0;
	}

	private function parseBreadcrumb($id) {
		// Fetch
		$breadcrumb = end($this->pdbc->fetch('SELECT `pid`,`name`,`url` FROM `pages` WHERE `id` = "' . $this->pdbc->quote($id) . '"'));

		// Stop
		if(empty($breadcrumb)) {
			return PHP_EOL;
		}

		// HTML
		return $this->parseBreadcrumb($breadcrumb['pid']) . '<li><a href="' . $breadcrumb['url'] . '">' . $breadcrumb['name'] . '</a></li>' . PHP_EOL;
	}
}

?>
