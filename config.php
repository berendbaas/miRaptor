<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */

// Init config
$config = array();

// Index
$config['index'] = array();
$config['index']['default_host'] = 'www.example.org';

// Mysql
$config['mysql'] = array();
$config['mysql']['username'] = 'username';
$config['mysql']['password'] = 'password';
$config['mysql']['database'] = 'database';
$config['mysql']['hostname'] = 'localhost';

// Gatekeeper
$config['gatekeeper'] = array();
$config['gatekeeper']['user_location'] = 'users';

// Parser
$config['parser'] = array();
$config['parser']['default_modules'] = array('media','menu','page','site','stylesheet','template');

?>
