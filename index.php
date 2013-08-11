<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */

// Globals
define('MIRAPTOR_CACHE', FALSE);
define('MIRAPTOR_DEBUG', TRUE);

// Include config
include_once('config.php');

// Autoload classes
function __autoload($class_name) {
	include_once('lib/classes/' . strtolower($class_name) . '.class.php');
}

// Output buffering start
ob_start();

// Run
try {
	// Set status code & parse request
	$statuscode = 200;
	$request = new Request($_SERVER['REQUEST_METHOD'], (empty($_SERVER['HTTP_HOST']) ? $config['index']['default_host'] : $_SERVER['HTTP_HOST']), new URI($_SERVER['REQUEST_URI']));

	// Select database
	$pdbc = new Mysql($config['mysql']);
	$pdbc->selectDatabase($config['mysql']['database']);

	// Select website
	$gatekeeper = new Gatekeeper($request, $pdbc, $config['gatekeeper']);

	// Parse page
	try {
		// Return page
		new Guide($gatekeeper, $request, $pdbc, $config['parser']);
	} catch(Exception $e) {
		// Set status code
		$statuscode = $e->getCode();

		// Return error page
		echo new Error($e);
	}

	// Log
	Logger::log(ob_get_length(), $statuscode, $_SERVER, $pdbc);
} catch(Exception $e) {
	if(!ob_get_length()) {
		// Return error page
		echo new Error($e);
	}
}

// Output buffering flush and end
ob_end_flush();

?>
