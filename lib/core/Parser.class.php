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
		$page = $this->page();
		$modules = $this->modules();

		while($token = $this->tokenizer->token()) {
			$this->tokenizer->replace($token, $this->module($token, $page, $modules));
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
	 *
	 */
	private function page() {
		$this->pdbc->query('SELECT `id`
		                    FROM `pages`
		                    WHERE `uri`="' . $this->pdbc->quote($this->url->getDirectory()) . '"');

		$page = $this->pdbc->fetch();

		if(!$page) {
			throw new \Exception('Parser: File doesnt exists - ' . $this->url->getPath() , 404);
		}

		return end($page);
	}

	/**
	 *
	 */
	private function modules() {
		$this->pdbc->query('SELECT `name` FROM `modules`');

		$modules = $this->pdbc->fetchAll();
		$result = array();

		foreach($modules as $module) {
			$result[] = $module['name'];
		}

		return $result;
	}

	/**
	 *
	 */
	private function module(Token $token, $page, array $modules = array()) {
		if(!in_array($token->getName(), $modules)) {
			throw new \Exception('Module doesn\'t exists', 500);
		}

		$module = self::MODULE_NAMESPACE . $token->getName() . self::MODULE_CLASS;

		$result = new $module($this->pdbc, $this->url, $page, $token->getArgs());
		$result->run();

		$this->isStatic = $this->isStatic && $result->isStatic();
		$this->isNamespace = $this->isNamespace || $result->isNamespace();

		return $result->__toString();
	}
}

?>
