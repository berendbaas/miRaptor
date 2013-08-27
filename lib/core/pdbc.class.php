<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
interface PDBC {
	/**
	 *
	 */
	public function __construct(array $config);

	/**
	 *
	 */
	public function selectDatabase($database);

	/**
	 *
	 */
	public function execute($query);

	/**
	 *
	 */
	public function fetch($query);

	/**
	 *
	 */
	public function quote($string);
}

?>
