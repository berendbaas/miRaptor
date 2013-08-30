<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Media implements ModuleInterface {
	private $pdbc;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->page = $page;
		$this->args = $args;
		$this->result = '';
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->result;
	}

	/**
	 *
	 */
	public function isStatic() {
		return TRUE;
	}

	/**
	 *
	 */
	public function run() {
		$get = $this->parseGet();
		$url = $this->parseUrl();

		switch($get) {
			case 'image':
				return $this->parseImage($url);
			break;
			case 'pdf':
				return $this->parsePdf($url);
			break;
			default:
				throw new Exception('get="' . $get . '" not supported.');
			break;
		}

		$this->result = $this->parseMedia($this->parseType(), $this->parseUrl());
	}

	/**
	 *
	 */
	private function parseGet() {
		if(isset($this->args['get'])) {
			return $this->args['get'];
		}

		throw new Exception('get="" required.');
	}

	/**
	 *
	 */
	private function parseUrl() {
		if(isset($this->args['url'])) {
			return $this->args['url'];
		}

		throw new Exception('url="" required.');
	}

	/**
	 *
	 */
	private function parseImage($url) {
		return '<img src="_media/images/' . $url . '" alt="' . (isset($this->args['alt']) ? $this->args['alt'] : '') . '" />';
	}

	/**
	 *
	 */
	private function parsePdf($url) {
		return '<a href="_media/pdf/' . $url . '" target="_blank">' .
		          (isset($this->args['alt']) ? $this->args['alt'] : '') .
		       '</a>';
	}
}

?>
