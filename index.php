<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */

// Include config
include_once('config.php');

// Autoload classes
function __autoload($className) {
	include_once('lib/core/' . $className . '.class.php');
}

// Create and start the main thread
$main = new Main($config);
$main->run();

?>
