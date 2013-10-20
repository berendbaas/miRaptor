<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Tokenizer {
	private $string;
	private $tokenStart;
	private $tokenEnd;

	/**
	 * Construct a Tokenizer object with the given string.
	 *
	 * @param string $string
	 * @param string $tokenStart = Token::DEFAULT_START
	 * @param string $tokenEnd = Token::DEFAULT_END
	 */
	public function __construct($string = '', $tokenStart = Token::DEFAULT_START, $tokenEnd = Token::DEFAULT_END) {
		$this->string = $string;
		$this->tokenStart = $tokenStart;
		$this->tokenEnd = $tokenEnd;
	}

	/**
	 * Returns a string representation of the Tokenizer object.
	 *
	 * @return string a string representation of the Tokenizer object.
	 */
	public function __toString() {
		return $this->string;
	}

	/**
	 * Replace the given token with the given replace.
	 *
	 * @param  string $token
	 * @param  string $replace = ''
	 * @return void
	 */
	public function replace($token, $replace = '') {
		$this->string = str_replace($token->__toString(), $replace, $this->string);
	}

	/**
	 * Returns a token or NULL if none are found.
	 *
	 * @returns Token a token or NULL if none are found.
	 */
	public function token() {
		$tokens = array();

		if(preg_match('/' . $this->tokenStart . '(.+?)' . $this->tokenEnd .  '/i', $this->string, $tokens)) {
			 return new Token($tokens[0]);
		}

		return NULL;
	}

	/**
	 * Returns an array containing all remaining tokens.
	 *
	 * @return array an array containing all remaining tokens.
	 */
	public function tokens() {
		$result = array();
		$tokens = array();

		if(preg_match_all('/' . $this->tokenStart . '(.+?)' . $this->tokenEnd .  '/i', $this->string, $tokens)) {
			foreach($tokens[0] as $token) {
				$result[] = new Token($token);
			}
		}

		return $result;
	}
}

?>
