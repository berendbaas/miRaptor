<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
abstract class AbstractAdmin implements Runnable {
	protected $pdbc;
	protected $url;
	protected $result;

	/**
	 * Construct an Admin object with the given PDBC & URL.
	 *
	 * @param \lib\pdbc\PDBC $pdbc
	 * @param URL            $url
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->result = '';
	}

	/**
	 * Returns the string representation of the Admin object.
	 *
	 * @return String the string representation of the Admin object.
	 */
	public function __toString() {
		return $this->result;
	}

	public abstract function run();
}

?>
