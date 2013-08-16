<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */

// Globals
define('MIRAPTOR_CACHE', FALSE);
define('MIRAPTOR_DEBUG', TRUE);

// Init config
$config = array();

// Main
$config['main'] = array();
$config['main']['default_host'] = 'www.example.org';
$config['main']['user_location'] = 'users';

// Mysql
$config['mysql'] = array();
$config['mysql']['username'] = 'username';
$config['mysql']['password'] = 'password';
$config['mysql']['database'] = 'database';
$config['mysql']['hostname'] = 'localhost';

?>
