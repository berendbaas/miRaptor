<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class SiteUninstall implements UninstallInterface {
	private $pdbc;
	private $result;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc) {
		$this->pdbc = $pdbc;
		$this->result = $result;
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
	public function run() {

	}
}

?>