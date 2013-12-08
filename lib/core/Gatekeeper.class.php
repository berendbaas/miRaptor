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
	 * Construct a Gatekeeper object with the given PDBC & URL.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @throws StatusCodeException     if the file isn't found at the current location or if the user doesn't exists.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url) {
		// Get website location & database
		$host = self::getHost($pdbc, $url);
		$location = self::getUser($pdbc, $url, $host['uid']);

		// Set website location & database
		$this->location = $location . $host['location'];
		$this->database = $host['db'];
	}

	/**
	 * Returns an array with the user ID, location & database of the host.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @return array                   an array with the user ID, location & database of the host.
	 * @throws StatusCodeException     if the file isn't found at the current location.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private static function getHost(\lib\pdbc\PDBC $pdbc, URL $url) {
		$pdbc->query('SELECT `uid`,`location`,`db`
		              FROM `website`
		              WHERE `active` = 1
		              AND `domain` = "' . $pdbc->quote($url->getHost()) . '"');

		$host = $pdbc->fetch();

		if(!$host) {
			self::getHostException($pdbc, $url);
		}

		return $host;
	}

	/**
	 * This function helps sefl::getHost() determine whether he has to throw a 301 or 404 exception.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @return void
	 * @throws StatusCodeException     if the file isn't found at the current location.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private static function getHostException(\lib\pdbc\PDBC $pdbc, URL $url) {
		$pdbc->query('SELECT `website`.`domain`, `redirect`.`path`
		              FROM `website`
		              RIGHT JOIN (SELECT `wid`,`path`
		                          FROM `redirect`
		                          WHERE `domain` = "' . $pdbc->quote($url->getHost()) . '") AS `redirect`
		              ON `website`.`id` = `redirect`.`wid`');

		$redirect = $pdbc->fetch();

		if(!$redirect) {
			throw new StatusCodeException('Gatekeeper: unknown domain - ' . $url->getHost(), StatusCodeException::ERROR_CLIENT_NOT_FOUND);
		}
			
		throw new StatusCodeException($url->getScheme() . URL::DELIMITER_SCHEME . $redirect['domain'] . $redirect['path'] . $url->getURI(), StatusCodeException::REDIRECTION_MOVED_PERMANENTLY);
	}

	/**
	 * Returns the user location.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @param  int                     $id
	 * @return string                  the user location.
	 * @throws StatusCodeException     if the user doesn't exists.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private static function getUser(\lib\pdbc\PDBC $pdbc, URL $url, $id) {
		$pdbc->query('SELECT `location`
		              FROM `user`
		              WHERE `id` = ' . $id);

		$user = $pdbc->fetch();

		if(!$user) {
			throw new StatusCodeException('Gatekeeper: unknown user - ' . $url->getHost(), StatusCodeException::ERROR_CLIENT_NOT_FOUND);
		}

		return end($user);
	}

	/**
	 * Returns the location of the website.
	 * 
	 * @return string the location of the website.
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Returns the database name of the website.
	 * 
	 * @return string the database name of the website.
	 */
	public function getDatabase() {
		return $this->database;
	}
}

?>
