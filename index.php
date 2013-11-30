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

// Globals
define('MIRAPTOR_DB', $config['pdbc']['database']);
define('MIRAPTOR_CACHE', FALSE);
define('MIRAPTOR_DEBUG', FALSE);

// Create and run main object
$pdbc = new \lib\pdbc\Mysqli($config['pdbc']['hostname'], $config['pdbc']['username'], $config['pdbc']['password'], $config['pdbc']['database']);
$main = new \lib\core\Main($pdbc, $config['default_host'], $config['user_directory']);
$main->run();

?>
