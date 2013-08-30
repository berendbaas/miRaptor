<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Logger {
	/**
	 *
	 */
	public static function log(PDBC $pdbc, $statuscode, $bandwidth) {
		$time = $pdbc->quote($_SERVER['REQUEST_TIME_FLOAT']);
		$runtime = (microtime(TRUE) - $time) * 1000;
		$request = $pdbc->quote($_SERVER['REQUEST_URI']);
		$referal = empty($_SERVER['HTTP_REFERER']) ? 'NULL' : '"' . $pdbc->quote($_SERVER['HTTP_REFERER']) . '"';
		$ip = $pdbc->quote($_SERVER['REMOTE_ADDR']);

		$pdbc->execute('INSERT INTO `log` (`id`, `time`, `runtime`, `bandwidth`, `statuscode`, `request`, `referal`, `ip`)
				VALUES (NULL, "' . $time . '", "' . $runtime . '", "' . $bandwidth . '", "' . $statuscode . '", "' . $request . '", ' . $referal . ', "' . $ip . '")');
	}
}