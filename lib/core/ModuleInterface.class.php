<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
interface ModuleInterface extends Runnable {
	/**
	 *
	 */
	public function __construct(PDBC $pdbc, Request $request, $page, array $args);

	/**
	 *
	 */
	public function __toString();

	/**
	 *
	 */
	public function isStatic();

	/**
	 *
	 */
	public function isNamespace();

	/**
	 *
	 */
	public function run();
}

?>