<?php
namespace lib/modules/stylesheet;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Install implements /lib/core/InstallInterface {
	private $pdbc;
	private $result;

	/**
	 *
	 */
	public function __construct(/lib/core/PDBC $pdbc) {
		$this->pdbc = $pdbc;
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
	public function run() {

	}
}

?>