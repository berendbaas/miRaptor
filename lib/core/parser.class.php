<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Parser implements Runnable {
	const MODULE_DEFAULT = 'template';
	const MODULE_LOCATION = 'lib/modules/';
	const MODULE_FILE = 'module.php';
	const MODULE_INTERFACE = 'ModuleInterface';

	private $request;
	private $pdbc;
	private $tokenizer;
	private $static;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, Request $request) {
		$this->pdbc = $pdbc;
		$this->request = $request;
		$this->tokenizer = new Tokenizer(Token::DEFAULT_START . self::MODULE_DEFAULT . Token::DEFAULT_END);
		$this->static = TRUE;
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
	}

	/**
	 *
	 */
	public function isStatic() {
		return $this->static;
	}

	/**
	 *
	 */
	private function page() {
		$page = end($this->pdbc->fetch('SELECT id
		                                FROM `pages`
		                                WHERE `url`="'. $this->pdbc->quote($this->request->getUri()->getPath()) . '"'));

		if(empty($page)) {
			throw new Exception('Parser: url doesnt exists - ' . $this->request->getUri()->getPath(), 404);
		}

		return end($page);
	}

	/**
	 *
	 */
	private function modules() {
		$modules = $this->pdbc->fetch('SELECT `name` FROM `modules`');

		foreach($modules as $module) {
			$result[] = $module['name'];
		}

		return $result;
	}

	/**
	 *
	 */
	private function module(array $modules, Token $token, $page) {
		$module = $token->getModule();
		$file = self::MODULE_LOCATION . $module . '/' . self::MODULE_FILE;

		try {
			if(!file_exists($file) || !in_array($module, $modules)) {
				throw new Exception('Module doensn\'t exists.');
			}

			include_once($file);

			if(!class_exists($module) || !in_array(self::MODULE_INTERFACE, class_implements($module))) {
				throw new Exception('Module doensn\'t exists.');
			}

			$result = new $module($this->pdbc, $page, $token->getArgs());
			$result->run();

			if(!$result->isStatic()) {
				$this->static = FALSE;
			}

			return $result->__toString();
		} catch(Exception $e) {
			return '<!-- {' . $module . '}: ' . $e->getMessage() . ' -->';
		}
	}
}

?>