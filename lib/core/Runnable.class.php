<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
interface Runnable {
	/**
	 * Run a separate part of the program.
	 *
	 * @return void
	 * @throws implementations may throw exceptions and are ought to be documented properly.
	 */
	public function run();
}

?>