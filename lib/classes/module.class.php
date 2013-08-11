<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
interface Module {
	public function __construct(array $args, $page, PDBC $pdbc);
	public function isStatic();
	public function get();
}

?>