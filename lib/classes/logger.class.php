<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Logger {
	/**
	 *
	 */
	public static function log(PDBC $pdbc, $statuscode, $bandwidth) {
		$time = $pdbc->quote($_SERVER['REQUEST_TIME_FLOAT']);
		$runtime = (microtime(TRUE) - $time) * 1000;
		$request =  $pdbc->quote($_SERVER['REQUEST_URI']);
		$referal =  $pdbc->quote(empty($_SERVER['HTTP_REFERER']) ? 'NULL' : '"' . $_SERVER['HTTP_REFERER'] . '"');
		$ip = $pdbc->quote($_SERVER['REMOTE_ADDR']);

		$pdbc->execute('INSERT INTO `log` (`id`, `time`, `runtime`, `bandwidth`, `statuscode`, `request`, `referal`, `ip`) VALUES (NULL, "' . $time . '", "' . $runtime . '", "' . $bandwidth . '", "' . $statuscode . '", "' . $request . '", ' . $referal . ', "' . $ip . '")');
	}
}