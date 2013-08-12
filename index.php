<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */

// Include config
include_once('config.php');

// Autoload classes
function __autoload($class_name) {
	include_once('lib/classes/' . strtolower($class_name) . '.class.php');
}

// Create and start the main thread
new Main($config)->run();

?>
