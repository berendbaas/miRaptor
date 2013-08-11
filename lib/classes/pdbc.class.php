<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
interface PDBC {
	public function __construct(array $config);
	public function selectDatabase($database);
	public function execute($query);
	public function fetch($query);
	public function quote($string);
}

?>
