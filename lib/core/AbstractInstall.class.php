<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
abstract class AbstractInstall implements Runnable {
	protected $pdbc;
	protected $result;

	/**
	 * Construct an Install object with the given PDBC.
	 *
	 * @param \lib\pdbc\PDBC $pdbc
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc) {
		$this->pdbc = $pdbc;
		$this->result = '';
	}

	/**
	 * Returns the string representation of the Install object.
	 *
	 * @return String the string representation of the Install object.
	 */
	public function __toString() {
		return $this->result;
	}

	public abstract function run();
}

?>