<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
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