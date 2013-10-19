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
	private $token_start;
	private $token_end;

	/**
	 * Construct a Tokenizer object with the given string.
	 *
	 * @param String $string
	 * @param String $token_start = Token::DEFAULT_START
	 * @param String $token_end = Token::DEFAULT_END
	 */
	public function __construct($string = '', $token_start = Token::DEFAULT_START, $token_end = Token::DEFAULT_END) {
		$this->string = $string;
		$this->token_start = $token_start;
		$this->token_end = $token_end;
	}

	/**
	 * Returns a string representation of the Tokenizer object.
	 *
	 * @return String a string representation of the Tokenizer object.
	 */
	public function __toString() {
		return $this->string;
	}

	/**
	 * Replace the given token with the given replace.
	 *
	 * @param  String $token
	 * @param  String $replace = ''
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

		if(preg_match('/' . $this->token_start . '(.+?)' . $this->token_end .  '/i', $this->string, $tokens)) {
			 return new Token($tokens[0]);
		}

		return NULL;
	}

	/**
	 * Returns an array containing all remaining tokens.
	 *
	 * @return Array an array containing all remaining tokens.
	 */
	public function tokens() {
		$result = array();
		$tokens = array();

		if(preg_match_all('/' . $this->token_start . '(.+?)' . $this->token_end .  '/i', $this->string, $tokens)) {
			foreach($tokens[0] as $token) {
				$result[] = new Token($token);
			}
		}

		return $result;
	}
}

?>
