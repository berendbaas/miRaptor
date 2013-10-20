<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Parser implements Runnable {
	const TOKEN_DEFAULT = 'template';
	const MODULE_CLASS = '\\Module';
	const MODULE_NAMESPACE = 'lib\\module\\';

	private $pdbc;
	private $url;
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
		$this->tokenizer = new Tokenizer(Token::DEFAULT_START . self::TOKEN_DEFAULT . Token::DEFAULT_END);

		$this->isStatic = TRUE;
		$this->isNamespace = FALSE;
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
		$routerID = $this->routerID();

		while($token = $this->tokenizer->token()) {
			$this->tokenizer->replace($token, $this->module($token, $routerID));
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
	 * Returns the router ID of the requested namespace / directory.
	 *
	 * @Returns int the router ID of the requested namespace / directory.
	 * @throws  Exception on failure.
	 */
	private function routerID() {
		$this->pdbc->query('SELECT `id`
		                    FROM `router`
		                    WHERE `namespace` = "' . $this->pdbc->quote($this->url->getDirectory()) . '"');

		$routerID = $this->pdbc->fetch();

		if(!$routerID) {
			throw new \Exception('Parser: File doesnt exists - ' . $this->url->getPath() , 404);
		}

		return end($routerID);
	}

	/**
	 * Returns the string representation of the module that belongs with the given token & router ID.
	 *
	 * @param   Token  $token
	 * @param   int    $routerID
	 * @returns String the string representation of the module that belongs with the given token & router ID.
	 * @throws  Exception on failure.
	 */
	private function module(Token $token, $routerID) {
		$module = self::MODULE_NAMESPACE . $token->getName() . self::MODULE_CLASS;

		$result = new $module($this->pdbc, $this->url, $routerID, $token->getArgs());
		$result->run();

		$this->isStatic = $this->isStatic && $result->isStatic();
		$this->isNamespace = $this->isNamespace || $result->isNamespace();

		return $result->__toString();
	}
}

?>
