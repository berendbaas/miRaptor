<?php
namespace lib/modules/site;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin implements /lib/core/AdminInterface {
	private $pdbc;
	private $uri;
	private $result;

	/**
	 *
	 */
	public function __construct(/lib/core/PDBC $pdbc, /lib/core/URI $uri) {
		$this->pdbc = $pdbc;
		$this->uri = $uri;
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
