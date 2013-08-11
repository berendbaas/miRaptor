<?php

/**
* @author miWebb <info@miwebb.com>
* @copyright Copyright (c) 2013, miWebb
* @version 1.0
*/
class Gatekeeper {
	private $location;

	public function __construct(Request $request, PDBC $pdbc, array $config) {
		// Get host
		$website = end($pdbc->fetch('SELECT `uid`,`location`,`db` FROM `website` WHERE `active` = 1 AND `domain` = "' . mysql_real_escape_string($request->getHost()) . '"'));

		// Check redirect or found
		if(empty($website)) {
			// Get redirect
			$redirect = end($pdbc->fetch('SELECT `website`.`domain`, `host`.`path` FROM `website` RIGHT JOIN (SELECT `wid`,`path` FROM `host` WHERE `domain` = "' . mysql_real_escape_string($request->getHost()) . '") AS `host` ON `website`.`id` = `host`.`wid`'));

			// Check redirect
			if(empty($redirect)) {
				throw new Exception('Gatekeeper: unknown domain - ' . $request->getHost(), 404);
			}

			// Redirect
			throw new Exception($redirect['domain'] . $redirect['path'] . $request->getUri(), 301);
		}

		// Get user location
		$user = end($pdbc->fetch('SELECT `location` FROM `user` WHERE `id` = ' . $website['uid']));

		// Check user
		if(empty($user)) {
			throw new Exception('Gatekeeper: unknown domain - ' . $request->getHost(), 404);
		}

		// Set website location & database
		$this->location = $config['user_location'] . $user['location'] . $website['location'];
		$pdbc->selectDatabase($website['db']);
	}

	public function getLocation() {
		return $this->location;
	}
}

?>