<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Parser implements Runnable {
	const DEFAULT_NAMESPACE = AbstractModule::DEFAULT_NAMESPACE;
	const DEFAULT_PARSABLE = AbstractModule::DEFAULT_PARSABLE;
	const DEFAULT_STATIC = AbstractModule::DEFAULT_STATIC;
	const DEFAULT_MODULE = 'template';

	const MODULE_CLASS = '\\Module';
	const MODULE_NAMESPACE = 'lib\\module\\';

	private $pdbc;
	private $url;

	private $modules;
	private $routerID;
	private $tokenizer;

	protected $isNamespace;
	protected $isParsable;
	protected $isStatic;

	/**
	 * Construct a Parser object with the given PDBC & URL.
	 *
	 * @param  \lib\pdbc\PDBC          $pdbc
	 * @param  \lib\util\URL  $url
	 * @throws StatusCodeException     if the requested file doesn't exists.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\util\URL $url, $module = self::DEFAULT_MODULE) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		
		$this->modules = $this->getModules();
		$this->routerID = $this->getRouterID();
		$this->tokenizer = $this->getTokenizer($module);

		$this->namespace = self::DEFAULT_NAMESPACE;
		$this->parsable = self::DEFAULT_PARSABLE;
		$this->static = self::DEFAULT_STATIC;
	}

	/**
	 * Returns an array with the modules you may use.
	 *
	 * @return array                   an array with the modules you may use.
	 * @throws \lib\pdbc\PDBCException if the query can't be executed.
	 */
	private function getModules() {
		$this->pdbc->query('SELECT `name`
		                    FROM `module`
		                    WHERE `active` = 1');

		$modules = array();

		while($module = $this->pdbc->fetch()) {
			$modules[] = $module['name'];
		}

		return $modules;
	}

	/**
	 * Returns the router ID.
	 *
	 * @return int                     the router ID.
	 * @throws StatusCodeException     if the requested file doesn't exists.
	 * @throws \lib\pdbc\PDBCException if the query can't be executed.
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
	 * Returns a tokenizer object with the given module.
	 *
	 * @return Tokenizer               returns a tokenizer object with the given module.
	 * @throws \lib\pdbc\PDBCException if the query can't be executed.
	 */
	private function getTokenizer($token) {
		return new Tokenizer(Token::DEFAULT_START . $token . Token::DEFAULT_END);
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
	 * Returns true if the parsed data is namespaced.
	 *
	 * @return boolean true if the parsed data is namespaced.
	 */
	public function isNamespace() {
		return $this->isNamespace;
	}

	/**
	 * Returns true if the parsed data is static.
	 *
	 * @return boolean true if the parsed data is static.
	 */
	public function isStatic() {
		return $this->isStatic;
	}

	public function run() {
		while(($token = $this->tokenizer->getToken()) !== NULL) {
			$this->tokenizer->replaceToken($this->getModule($token), $this->isParsable);
		}
	}

	/**
	 * Returns the string representation of the module that belongs to the given token.
	 *
	 * @param  Token      $token
	 * @return string     the string representation of the module that belongs to the given token.
	 * @throws \Exception implementations of the AbstractModule may throw exceptions or implementations of the Exception class and are ought to be documented properly.
	 */
	private function getModule(Token $token) {
		try {
			// Access
			if(!in_array($token->getName(), $this->modules)) {
				$this->parsable = FALSE;
				return $token->__toString();
			}

			// Run
			$module = self::MODULE_NAMESPACE . $token->getName() . self::MODULE_CLASS;
			$result = new $module($this->pdbc, $this->url, $this->routerID, $token->getArgs());
			$result->run();

			// Vars
			$this->isNamespace = $result->isNamespace() !== self::DEFAULT_NAMESPACE ? $result->isNamespace() : $this->isNamespace;
			$this->isParsable = $result->isParsable();
			$this->isStatic = $result->isStatic() !== self::DEFAULT_NAMESPACE ? $result->isStatic() : $this->isStatic;

			// Return
			return $result->__toString();
		} catch(ModuleException $e) {
			return '<!--' . $token->getName() . ': ' . $e->getMessage() . '-->';
		}
	}
}

?>
