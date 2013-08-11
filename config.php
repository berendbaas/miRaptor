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
$config['index']['default_host'] = 'www.miraptor.nl';

// Mysql
$config['mysql'] = array();
$config['mysql']['username'] = 'root';
$config['mysql']['password'] = 'Teemoskills!';
$config['mysql']['database'] = 'miraptor_cms';
$config['mysql']['hostname'] = 'localhost';

// Gatekeeper
$config['gatekeeper'] = array();
$config['gatekeeper']['user_location'] = 'users';

// Parser
$config['parser'] = array();
$config['parser']['default_modules'] = array('media','menu','page','site','stylesheet','template');

?>
