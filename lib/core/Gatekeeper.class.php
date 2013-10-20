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
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url) {
		// Get website location & database
		$host = $this->getHost($pdbc, $url);
		$user = $this->getUser($pdbc, $url, $host['uid']);

		// Set website location & database
		$this->location = $user['location'] . $host['location'];
		$this->database = $host['db'];
	}

	/**
	 *
	 */
	private function getHost(\lib\pdbc\PDBC $pdbc, URL $url) {
		$pdbc->query('SELECT `uid`,`location`,`db`
		              FROM `website`
		              WHERE `active` = 1
		              AND `domain` = "' . $pdbc->quote($url->getHost()) . '"');

		$host = $pdbc->fetch();

		if(!$host) {
			$this->getHostRedirect($pdbc, $url);
		}

		return $host;r
	}

	/**
	 *
	 */
	private function getHostRedirect(\lib\pdbc\PDBC $pdbc, URL $url) {
		$pdbc->query('SELECT `website`.`domain`, `host`.`path`
		              FROM `website`
		              RIGHT JOIN (SELECT `wid`,`path`
		                          FROM `host`
		                          WHERE `domain` = "' . $pdbc->quote($url->getHost()) . '") AS `host`
		              ON `website`.`id` = `host`.`wid`');

		$redirect = $pdbc->fetch();

		if(!$redirect) {
			throw new \Exception('Gatekeeper: unknown domain - ' . $url->getHost(), 404);
		}
			
		throw new \Exception($url->getScheme() . URL::DELIMITER_SCHEME . $redirect['domain'] . $redirect['path'] . $url->getURI(), 301);
	}

	/**
	 * 
	 */
	private function getUser(\lib\pdbc\PDBC $pdbc, URL $url, $id) {
		$pdbc->query('SELECT `location`
		              FROM `user`
		              WHERE `id` = ' . $id);

		$user = $pdbc->fetch();

		if(!$user) {
			throw new \Exception('Gatekeeper: unknown user - ' . $url->getHost(), 404);
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
