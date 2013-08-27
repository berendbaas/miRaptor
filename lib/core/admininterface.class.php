<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
interface AdminInterface {
	/**
	 *
	 */
	public function __construct(URI $uri, PDBC $pdbc);

	/**
	 *
	 */
	public function get();
}

?>