<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Tokenizer {
	private $input;
	private $result;
	private $token;

	private $tokenStart;
	private $tokenEnd;

	/**
	 * Construct a Tokenizer object with the given string.
	 *
	 * @param string $input
	 * @param string $tokenStart = Token::DEFAULT_START
	 * @param string $tokenEnd = Token::DEFAULT_END
	 */
	public function __construct($input = '', $tokenStart = Token::DEFAULT_START, $tokenEnd = Token::DEFAULT_END) {
		$this->input = $input;
		$this->result = '';
		$this->token = NULL;
		$this->tokenStart = $tokenStart;
		$this->tokenEnd = $tokenEnd;
	}

	/**
	 * Returns a string representation of the Tokenizer object.
	 *
	 * @return string a string representation of the Tokenizer object.
	 */
	public function __toString() {
		return $this->result . $this->input;
	}

	/**
	 * Replace the first parsable token with the given content.
	 *
	 * @param  string  $replace = ''
	 * @param  boolean $parsable = TRUE
	 * @return void
	 */
	public function replace($replace = '', $parsable = TRUE) {
		if($this->token == NULL) {
			return;
		}

		if($parsable) {
			$this->input = $replace . $this->input;
		} else {
			$this->result .= $replace;
		}

		$this->token = NULL;
	}

	/**
	 * Returns the first parsable token or NULL if none are found.
	 *
	 * @returns Token the first parsable token or NULL if none are found.
	 */
	public function token() {
		if($this->input == '') {
			return NULL;
		}

		if($this->token == NULL) {
			$tokens = array();

			if(preg_match('/' . $this->tokenStart . '[\w\s="]+' . $this->tokenEnd .  '/i', $this->input, $tokens)) {
				$this->token = new Token($tokens[0]);
			} else {
				$this->token = NULL;
			}
		}

		$buffer = preg_split('/' . $this->tokenStart . '[\w\s="]+' . $this->tokenEnd . '/i', $this->input, 2);
		$this->input = (isset($buffer[1]) ? $buffer[1] : '');
		$this->result .= $buffer[0];

		return $this->token;
	}
}

?>
