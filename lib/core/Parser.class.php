<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Parser implements Runnable {
	const MODULE_CLASS = '\\Module';
	const MODULE_NAMESPACE = 'lib\\module\\';

	private $pdbc;
	private $url;
	private $routerID;
	private $tokenizer;

	private $isStatic;
	private $isNamespace;

	/**
	 * Construct a Parser object with the given PDBC & URL.
	 *
	 * @param  \lib\pdbc\PDBC      $pdbc
	 * @param  URL                 $url
	 * @throws StatusCodeException on failure.
	 * @throws PDBCException       on PDBC failure.
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->routerID = $this->getRouterID();
		$this->tokenizer = $this->getTokenizer();

		$this->isStatic = TRUE;
		$this->isNamespace = FALSE;
	}

	/**
	 * Returns the router ID.
	 *
	 * @return int                 the router ID.
	 * @throws StatusCodeException on failure.
	 * @throws PDBCException       on PDBC failure.
	 */
	private function getRouterID() {
		$this->pdbc->query('SELECT `id`
		                    FROM `router`
		                    WHERE `uri` = "' . $this->pdbc->quote($this->url->getDirectory()) . '"');

		$routerID = $this->pdbc->fetch();

		if(!$routerID) {
			throw new StatusCodeException('Parser: URI doesn\'t exist - ' . $this->url->getPath(), StatusCodeException::ERROR_CLIENT_NOT_FOUND);
		}

		return end($routerID);
	}

	/**
	 * Returns a tokenizer object.
	 *
	 * @return Tokenizer         returns a tokenizer object.
	 * @throws PDBCException     on PDBC failure.
	 */
	private function getTokenizer() {
		$this->pdbc->query('SELECT `content`
		                    FROM `template`
		                    WHERE `id` = (SELECT `tid`
		                                  FROM `router`
	                                          WHERE `id` = "' . $this->pdbc->quote($this->routerID) . '")');

		return new Tokenizer(end($this->pdbc->fetch()));
	}

	/**
	 * Returns a string representation of the Parser object.
	 *
	 * @return string a string representation of the Parser object.
	 */
	public function __toString() {
		return $this->tokenizer->__toString();
	}

	/**
	 * Returns true if the parsed data is static.
	 *
	 * @return boolean true if the parsed data is static.
	 */
	public function isStatic() {
		return $this->isStatic;
	}

	/**
	 * Returns true if the parsed data is namespaced.
	 *
	 * @return boolean true if the parsed data is namespaced.
	 */
	public function isNamespace() {
		return $this->isNamespace;
	}

	public function run() {
		while($token = $this->tokenizer->token()) {
			$this->tokenizer->replace($token, $this->module($token));
		}
	}

	/**
	 * Returns the string representation of the module that belongs with the given token.
	 *
	 * @param  Token               $token
	 * @return string              the string representation of the module that belongs with the given token.
	 * @throws StatusCodeException on failure.
	 * @throws PDBCException       on PDBC failure.
	 */
	private function module(Token $token) {
		$module = self::MODULE_NAMESPACE . $token->getName() . self::MODULE_CLASS;

		$result = new $module($this->pdbc, $this->url, $this->routerID, $token->getArgs());
		$result->run();

		$this->isStatic = $this->isStatic && $result->isStatic();
		$this->isNamespace = $this->isNamespace || $result->isNamespace();

		return $result->__toString();
	}
}

?>
