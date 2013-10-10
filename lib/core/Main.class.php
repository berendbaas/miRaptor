<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Main implements Runnable {
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
			// Init
			$url = $this->parseURL();
			$pdbc = $this->parsePDBC($this->config['mysql']);

			// Run
			$gatekeeper = $this->parseGatekeeper($pdbc, $url);
			new Guide($pdbc, $url, $this->config['main']['user_location'] . $gatekeeper->getLocation());
		} catch(\Exception $e) {
			$this->statuscode = $e->getCode();
			echo new Error($e);
		}
		
		if(isset($pdbc)) {
			Logger::log($pdbc, $this->statuscode, ob_get_length());
		}

		ob_end_flush();
	}

	/**
	 * 
	 */
	private function parseURL() {
		$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$host = empty($_SERVER['HTTP_HOST']) ? $this->config['main']['default_host'] : $_SERVER['HTTP_HOST'];

		return new URL($scheme, $host, $_SERVER['REQUEST_URI']);
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
	private function parseGatekeeper(PDBC $pdbc, URL $url) {
		$gatekeeper = new Gatekeeper($pdbc, $url);
		$pdbc->selectDatabase($gatekeeper->getDatabase());

		return $gatekeeper;
	}
}

?>
