<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */

// Config
$config = array();
$config['cache'] = FALSE;
$config['debug'] = TRUE;
$config['default_host'] = 'www.example.org';
$config['timezone'] = 'Europe/Amsterdam';
$config['user_directory'] =  __DIR__ . DIRECTORY_SEPARATOR . 'users';

// PHP DataBase Connector (PDBC)
$config['pdbc'] = array();
$config['pdbc']['username'] = 'username';
$config['pdbc']['password'] = 'password';
$config['pdbc']['database'] = 'database';
$config['pdbc']['hostname'] = 'localhost';

?>