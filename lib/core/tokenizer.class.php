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
	 *
	 */
	public function __construct($input = '', $token_start = Token::DEFAULT_START, $token_end = Token::DEFAULT_END) {
		$this->string = $input;
		$this->token_start = $token_start;
		$this->token_end = $token_end;
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->string;
	}

	/**
	 *
	 */
	public function replace($token, $replacement = '') {
		$this->string = str_replace($token->__toString(), $replacement, $this->string);
	}

	/**
	 *
	 */
	public function token() {
		if(preg_match('/' . $this->token_start . '(.+?)' . $this->token_end .  '/i', $this->string, $token)) {
			 return new Token($token[0]);
		}

		return NULL;
	}

	/**
	 *
	 */
	public function tokens() {
		if(preg_match_all('/' . $this->token_start . '(.+?)' . $this->token_end .  '/i', $this->string, $tokens)) {
			foreach($tokens[0] as $token) {
				$result[] = new Token($token);
			}

			return $result;

		}

		return NULL;
	}
}

?>