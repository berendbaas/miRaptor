<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Gatekeeper {
	const DEFAULT_FILE = 'index.html';

	private $pdbc;
	private $url;
	private $userDirectory;
	private $file;

	/**
	 * Construct a Gatekeeper object with the given PDBC, URL & user directory.
	 *
	 * @param \lib\pdbc\PDBC $pdbc
	 * @param \lib\util\URL  $url
	 * @param string         $userDirectory
	 * @throws StatusCodeException     if the requested website can't be found.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\util\URL $url, $userDirectory) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->userDirectory = $userDirectory;

		$this->init();
	}

	/**
	 * Init the gatekeeper object.
	 *
	 * @return void
	 * @throws StatusCodeException     if the requested website can't be found.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private function init() {
		$this->pdbc->query('SELECT CONCAT(`user`.`directory`, `website`.`directory`) as `directory`, `db`
		                    FROM `website`
		                    LEFT JOIN `user`
		                    ON `website`.`uid` = `user`.`id`
		                    WHERE `active` = 1
		                    AND `host` = "' . $this->pdbc->quote($this->url->getHost()) . '"');

		$website = $this->pdbc->fetch();

		if($website === NULL) {
			$this->redirect();
		}
		
		$this->file = new \lib\util\File($this->userDirectory . $website['directory'] . $this->url->getDirectory() . ($this->url->getFile() === '' ? self::DEFAULT_FILE : $this->url->getFile()));
		$this->pdbc = clone $this->pdbc;
		$this->pdbc->selectDatabase($website['db']);
	}

	/**
	 * Try to redirect to the correct website, if possible.
	 *
	 * @return void
	 * @throws StatusCodeException     if the requested website can't be found.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private function redirect() {
		$this->pdbc->query('SELECT `website`.`host`, `redirect`.`path`
		                    FROM `website`
		                    RIGHT JOIN (SELECT `wid`,`path`
		                                FROM `redirect`
		                                WHERE `host` = "' . $this->pdbc->quote($this->url->getHost()) . '") AS `redirect`
		                    ON `website`.`id` = `redirect`.`wid`');

		$redirect = $this->pdbc->fetch();

		if($redirect === NULL) {
			throw new StatusCodeException('Gatekeeper: unknown host - ' . $this->url->getHost(), StatusCodeException::ERROR_CLIENT_NOT_FOUND);
		}

		$this->url->setHost($redirect['host']);
		$this->url->setPath($redirect['path']);

		throw new StatusCodeException($this->url, StatusCodeException::REDIRECTION_MOVED_PERMANENTLY);
	}

	/**
	 * Returns the requested File object.
	 *
	 * @return File the requested File object.
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Returns the requested PDBC object.
	 *
	 * @return \lib\pdbc\PDBC the requested PDBC object.
	 */
	public function getPDBC() {
		return $this->pdbc;
	}
}

?>
