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
	private $static;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, Request $request) {
		$this->pdbc = $pdbc;
		$this->request = $request;
		$this->tokenizer = new Tokenizer(Token::DEFAULT_START . self::TOKEN_DEFAULT . Token::DEFAULT_END);
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
		$page = end($this->pdbc->fetch('SELECT `id`
		                                FROM `pages`
		                                WHERE `url`="' . $this->pdbc->quote($this->request->getUri()->getPath()) . '"'));

		if(empty($page)) {
			throw new \Exception('Parser: url doesnt exists - ' . $this->request->getUri()->getPath(), 404);
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
		try {
			$module = self::MODULE_NAMESPACE . $token->getModule() . self::MODULE_CLASS;
			echo $module;

			$result = new $module($this->pdbc, $page, $token->getArgs());
			$result->run();

			if(!$result->isStatic()) {
				$this->static = FALSE;
			}

			return $result->__toString();
		} catch(\Exception $e) {
			return '<!-- {' . $token->getModule() . '}: ' . $e->getMessage() . ' -->';
		}
	}
}

?>
