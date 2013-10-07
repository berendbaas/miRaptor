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
	const MODULE_NAMESPACE = 'lib\\modules\\';

	private $request;
	private $pdbc;
	private $tokenizer;

	private $isStatic;
	private $isNamespace;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, Request $request) {
		$this->pdbc = $pdbc;
		$this->request = $request;
		$this->tokenizer = new Tokenizer(Token::DEFAULT_START . self::TOKEN_DEFAULT . Token::DEFAULT_END);

		$this->isStatic = TRUE;
		$this->isNamespace = FALSE;
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->tokenizer->__toString();
	}

	/**
	 *
	 */
	public function run() {
		$page = $this->page();
		$modules = $this->modules();

		while($token = $this->tokenizer->token()) {
			$this->tokenizer->replace($token, $this->module($modules, $token, $page));
		}

		// The page exists, but is considered not found because the filename was not required.
		if(!$this->isNamespace && $this->request->getUri()->getFilename() != '') {
			throw new \Exception('Parser: uri doesnt exists - ' . $this->request->getUri()->getPath() . $this->request->getUri()->getFilename() , 404);
		}
	}

	/**
	 *
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
		                    WHERE `uri`="' . $this->pdbc->quote($this->request->getUri()->getPath()) . '"');

		$page = $this->pdbc->fetch();

		if(empty($page)) {
			throw new \Exception('Parser: uri doesnt exists - ' . $this->request->getUri()->getPath() . $this->request->getUri()->getFilename() , 404);
		}

		return end($page);
	}

	/**
	 *
	 */
	private function modules() {
		$this->pdbc->query('SELECT `name` FROM `modules`');

		$modules = $this->pdbc->fetchAll();

		foreach($modules as $module) {
			$result[] = $module['name'];
		}

		return $result;
	}

	/**
	 *
	 */
	private function module(array $modules, Token $token, $page) {
		$module = self::MODULE_NAMESPACE . $token->getModule() . self::MODULE_CLASS;

		$result = new $module($this->pdbc, $this->request, $page, $token->getArgs());
		$result->run();

		$this->isStatic = $this->isStatic && $result->isStatic();
		$this->isNamespace = $this->isNamespace || $result->isNamespace();

		return $result->__toString();
	}
}

?>
