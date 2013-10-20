<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Token {
	const DEFAULT_START = '<!--{';
	const DEFAULT_END = '}-->';

	private $token;
	private $tokenStart;
	private $tokenEnd;

	private $name;
	private $args;

	/**
	 * Construct a Token object with the given token.
	 *
	 * @param string $token
	 * @param string $tokenStart = Token::DEFAULT_START
	 * @param string $tokenEnd = Token::DEFAULT_END
	 */
	public function __construct($token, $tokenStart = self::DEFAULT_START, $tokenEnd = self::DEFAULT_END) {
		// Set token
		$this->token = $token;
		$this->tokenStart = $tokenStart;
		$this->tokenEnd = $tokenEnd;

		// Parse module
		$input = explode(' ', substr($token, strlen($tokenStart), -strlen($tokenEnd)), 2);
		$this->name = array_shift($input);

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
	 * Returns a string representation of the Token object.
	 *
	 * @return string a string representation of the Token object.
	 */
	public function __toString() {
		return $this->token;
	}

	/**
	 * Returns the name.
	 *
	 * @return string the name.
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns the arguments.
	 *
	 * @return array the arguments
	 */
	public function getArgs() {
		return $this->args;
	}
}

?>
