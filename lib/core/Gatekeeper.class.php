<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Gatekeeper {
	private $location;
	private $database;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, Request $request) {
		// Get website location & database
		$host = $this->getHost($pdbc, $request);
		$user = $this->getUser($pdbc, $request, $host['uid']);

		// Set website location & database
		$this->location = $user['location'] . $host['location'];
		$this->database = $host['db'];
	}

	/**
	 *
	 */
	private function getHost(PDBC $pdbc, Request $request) {
		$pdbc->query('SELECT `uid`,`location`,`db`
		              FROM `website`
		              WHERE `active` = 1
		              AND `domain` = "' . $pdbc->quote($request->getHost()) . '"');

		$host = $pdbc->fetch();

		if(empty($host)) {
			$this->getHostRedirect();
		}

		return $host;
	}

	/**
	 *
	 */
	private function getHostRedirect() {
		$pdbc->query('SELECT `website`.`domain`, `host`.`path`
		              FROM `website`
		              RIGHT JOIN (SELECT `wid`,`path`
		                          FROM `host`
		                          WHERE `domain` = "' . $pdbc->quote($request->getHost()) . '") AS `host`
		              ON `website`.`id` = `host`.`wid`)');

		$redirect = $pdbc->fetch();

		if(empty($redirect)) {
			throw new \Exception('Gatekeeper: unknown domain - ' . $request->getHost(), 404);
		}
			
		throw new \Exception($redirect['domain'] . $redirect['path'] . $request->getUri(), 301);
	}

	/**
	 * 
	 */
	private function getUser(PDBC $pdbc, Request $request, $id) {
		$pdbc->query('SELECT `location`
		              FROM `user`
		              WHERE `id` = ' . $id);

		$user = $pdbc->fetch();

		if(empty($user)) {
			throw new \Exception('Gatekeeper: unknown domain - ' . $request->getHost(), 404);
		}

		return $user;
	}

	/**
	 * 
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * 
	 */
	public function getDatabase() {
		return $this->database;
	}
}

?>
