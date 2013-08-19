<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Token {
	const DEFAULT_START = '<!--{';
	const DEFAULT_END = '}-->';

	private $module;
	private $args;
	private $token;
	private $token_start;
	private $token_end;

	/**
	 *
	 */
	public function __construct($token, $token_start = self::DEFAULT_START, $token_end = self::DEFAULT_END) {
		// Set token
		$this->token = $token;
		$this->token_start = $token_start;
		$this->token_end = $token_end;

		// Parse module
		$input = explode(' ', substr($token, strlen($token_start), -strlen($token_end)), 2);
		$this->module = array_shift($input);

		// Parse arguments
		$this->args = array();
		while(($input = trim(current($input))) != '') {
			// Set key
			$input = explode('="',$input,2);
			$key = array_shift($input);

			// Set value
			$input = explode('"',current($input),2);
			$value = array_shift($input);

			// Store args
			$this->args[$key] = $value;
		}
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->token;
	}

	/**
	 *
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 *
	 */
	public function getArgs() {
		return $this->args;
	}
}

?>