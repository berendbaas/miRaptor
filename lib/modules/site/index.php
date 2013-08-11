<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Site implements Module {
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
		return $this->parseSite($this->parseGet());
	}

	private function parseGet() {
		if(isset($this->args['get'])) {
			return $this->args['get'];
		}

		throw new Exception('get="" required.');
	}

	private function parseSite($get) {
		$result = $this->pdbc->fetch('SELECT `content` FROM `module_site` WHERE `name` = "' . $this->pdbc->quote($get) . '"');

		if(empty($result)) {
			throw new Exception('get="' . $get . '" does not exists.');
		}

		return end(end($result));
	}
}

?>