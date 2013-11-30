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

		$this->nextToken();
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
	 * Returns the first parsable token or NULL if none are found.
	 *
	 * @returns Token the first parsable token or NULL if none are found.
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * Replace the first parsable token with the given content.
	 *
	 * @param  string  $replace = ''
	 * @param  boolean $parsable = TRUE
	 * @return void
	 */
	public function replaceToken($replace = '', $parsable = TRUE) {
		if($this->token !== NULL) {
			if($parsable) {
				$this->input = $replace . $this->input;
			} else {
				$this->result .= $replace;
			}

			$this->nextToken();
		}
	}

	/**
	 * Iterate to the next token in the input.
	 *
	 * @return void
	 */
	private function nextToken() {
		$buffer = preg_split('/(' . $this->tokenStart . '[\w\s="]+' . $this->tokenEnd . ')/i', $this->input, 2, PREG_SPLIT_DELIM_CAPTURE);

		if(isset($buffer[2])) {
			$this->input = $buffer[2];
			$this->token = new Token($buffer[1], $this->tokenStart, $this->tokenEnd);
		} else {
			$this->input = '';
			$this->token = NULL;
		}

		$this->result .= $buffer[0];
	}
}

?>
