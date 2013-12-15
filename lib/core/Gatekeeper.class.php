<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Gatekeeper {
	private $directory;
	private $database;

	/**
	 * Construct a Gatekeeper object with the given PDBC & URL.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @throws StatusCodeException     if the file isn't found at the current directory or if the user doesn't exists.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url) {
		// Get website directory & database
		$website = self::getWebsite($pdbc, $url);
		$directory = self::getUser($pdbc, $url, $website['uid']);

		// Set website directory & database
		$this->directory = $directory . $website['directory'];
		$this->database = $website['db'];
	}

	/**
	 * Returns an array with the user ID, directory & database of the website.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @return array                   an array with the user ID, directory & database of the website.
	 * @throws StatusCodeException     if the file isn't found at the current directory.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private static function getWebsite(\lib\pdbc\PDBC $pdbc, URL $url) {
		$pdbc->query('SELECT `uid`, `directory`, `db`
		              FROM `website`
		              WHERE `active` = 1
		              AND `domain` = "' . $pdbc->quote($url->getHost()) . '"');

		$website = $pdbc->fetch();

		if(!$website) {
			self::getWebsiteException($pdbc, $url);
		}

		return $website;
	}

	/**
	 * This function helps self::getWebsite() determine whether he has to throw a 301 or 404 exception.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @return void
	 * @throws StatusCodeException     if the file isn't found at the current directory.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private static function getWebsiteException(\lib\pdbc\PDBC $pdbc, URL $url) {
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
	 * Returns the user directory.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  URL                     $url
	 * @param  int                     $id
	 * @return string                  the user directory.
	 * @throws StatusCodeException     if the user doesn't exists.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private static function getUser(\lib\pdbc\PDBC $pdbc, URL $url, $id) {
		$pdbc->query('SELECT `directory` FROM `user` WHERE `id` = ' . $id);

		$user = $pdbc->fetch();

		if(!$user) {
			throw new StatusCodeException('Gatekeeper: unknown user - ' . $url->getHost(), StatusCodeException::ERROR_CLIENT_NOT_FOUND);
		}

		return end($user);
	}

	/**
	 * Returns the directory of the website.
	 * 
	 * @return string the directory of the website.
	 */
	public function getDirectory() {
		return $this->directory;
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
