<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Main {
	private $statuscode;
	private $config;

	/**
	 *
	 */
	public function __construct(array $config) {
		$this->statuscode = 200;
		$this->config = $config;
	}

	/**
	 * 
	 */
	public function run() {
		ob_start();

		try {
			$request = $this->parseRequest();
			$pdbc = $this->parsePDBC($this->config['mysql']);
			$gatekeeper = $this->parseGatekeeper($pdbc, $request);
			new Guide($pdbc, $request, $this->config['main']['user_location'] . $gatekeeper->getLocation(), $config['parser']);
		} catch(Exception $e) {
			$statuscode = $e->getCode();
			echo new Error($e);
		} 
		
		if($pdbc != null) {
			Logger::log($pdbc, $statuscode, ob_get_length());
		}

		ob_end_flush();
	}

	/**
	 *
	 */
	private function parseRequest() {
		$method = $_SERVER['REQUEST_METHOD'];
		$host = empty($_SERVER['HTTP_HOST']) ? $this->config['main']['default_host'] : $_SERVER['HTTP_HOST'];
		$uri = new URI($_SERVER['REQUEST_URI']);

		return new Request($method, $host, $uri);
	}

	/**
	 *
	 */
	private function parsePDBC($config) {
		$pdbc = new Mysql($config);
		$pdbc->selectDatabase($config['database']);

		return $pdbc;
	}

	/**
	 *
	 */
	private function parseGatekeeper(PDBC $pdbc, Request $request) {
		$gatekeeper = new Gatekeeper($pdbc, $request);
		$pdbc->selectDatabase($gatekeeper->getDatabase());

		return $gatekeeper;
	}
}

?>