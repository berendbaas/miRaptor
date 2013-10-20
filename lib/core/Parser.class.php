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
	 * @param \lib\pdbc\PDBC $pdbc
	 * @param URL            $url
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
	 * @Returns int the router ID.
	 * @throws  Exception on failure.
	 */
	private function getRouterID() {
		$this->pdbc->query('SELECT `id`
		                    FROM `router`
		                    WHERE `uri` = "' . $this->pdbc->quote($this->url->getDirectory()) . '"');

		$routerID = $this->pdbc->fetch();

		if(!$routerID) {
			throw new \Exception('Parser: File doesnt exists - ' . $this->url->getPath() , 404);
		}

		return end($routerID);
	}

	/**
	 * Returns a tokenizer object.
	 *
	 * @Returns Tokenizer Returns a tokenizer object.
	 * @throws  Exception on failure.
	 */
	private function getTokenizer() {
		$this->pdbc->query('SELECT `content`
		                    FROM `template`
		                    WHERE `id` = (SELECT `tid`
		                                  FROM `router`
	                                          WHERE `id` = "' . $this->pdbc->quote($this->routerID) . '")');

		$template = $this->pdbc->fetch();

		if(!$template) {
			throw new \Exception('Parser: Template does not exists.');
		}

		return new Tokenizer(end($template));
	}

	/**
	 * Returns a string representation of the Parser object.
	 *
	 * @return String a string representation of the Parser object.
	 */
	public function __toString() {
		return $this->tokenizer->__toString();
	}

	public function run() {
		while($token = $this->tokenizer->token()) {
			$this->tokenizer->replace($token, $this->module($token));
		}

		// The page exists, but is considered not found because the filename was not required.
		if(!$this->isNamespace && $this->url->getFile() != '') {
			throw new \Exception('Parser: File doesn\'t exists - ' . $this->url->getPath() , 404);
		}
	}

	/**
	 * Returns true if the parser if static.
	 *
	 * @return boolean true if the parser is static.
	 */
	public function isStatic() {
		return $this->isStatic;
	}

	/**
	 * Returns the string representation of the module that belongs with the given token & router ID.
	 *
	 * @param   Token  $token
	 * @param   int    $routerID
	 * @returns String the string representation of the module that belongs with the given token & router ID.
	 * @throws  Exception on failure.
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
