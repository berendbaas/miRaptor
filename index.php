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
function __autoload($class) {
	include_once(str_replace('\\', '/', $class) . '.class.php');
}

// Create and run main object
$main = new lib\core\Main($config);
$main->run();

?>
