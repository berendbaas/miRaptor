<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Logger {
	public static function log($bandwidth, $statuscode, array $server, PDBC $pdbc) {
		$time = $_SERVER['REQUEST_TIME_FLOAT'];
		$runtime = (microtime(TRUE) - $time) * 1000;

		$pdbc->execute('INSERT INTO `log` (`id`, `time`, `runtime`, `bandwidth`, `statuscode`, `request`, `referal`, `ip`) VALUES (NULL, "' . $time . '", "' . $runtime . '", "' . $bandwidth . '", "' . $statuscode . '", "' . $_SERVER['REQUEST_URI'] . '", ' . (empty($_SERVER['HTTP_REFERER']) ? 'NULL' : '"' . $_SERVER['HTTP_REFERER'] . '"') . ', "' . $_SERVER['REMOTE_ADDR'] . '")');
	}
}