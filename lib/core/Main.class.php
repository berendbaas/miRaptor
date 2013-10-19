<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Main implements Runnable {
	private $pdbc;
	private $url;
	private $location;
	private $statuscode;

	/**
	 * Construct a Main object with the given config.
	 *
	 * @param Array $config
	 */
	public function __construct(array $config) {
		$this->pdbc = $this->initPDBC($config['pdbc']);
		$this->url = $this->initURL($config['main']['default_host']);
		$this->location = $config['main']['user_location'];
		$this->statuscode = 200;
	}

	/**
	 * Returns a PDBC object.
	 *
	 * @param  Array          $config
	 * @return \lib\pdbc\PDBC a PDBC object.
	 */
	public function initPDBC(Array $config) {
		$pdbc = new \lib\pdbc\Mysql($config['hostname'], $config['username'], $config['password']);
		$pdbc->selectDatabase($config['database']);

		return $pdbc;
	}

	/**
	 * Returns a URL object.
	 *
	 * @param  String $defaultHost
	 * @return URL    a URL object.
	 */
	public function initURL($defaultHost) {
		$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$host = empty($_SERVER['HTTP_HOST']) ? $defaultHost : $_SERVER['HTTP_HOST'];

		return new URL($scheme, $host, $_SERVER['REQUEST_URI']);
	}

	public function run() {
		// start buffer
		ob_start();

		try {
			// Gatekeeper
			$gatekeeper = new Gatekeeper($this->pdbc, $this->url);
			$this->pdbc->selectDatabase($gatekeeper->getDatabase());

			// Guide
			new Guide($this->pdbc, $this->url, $this->location . $gatekeeper->getLocation());
		} catch(lib\pdbc\PDBCException $e) {
			// Handle PDBC exception
			$this->statuscode = 500;
			echo new Error($e);
		} catch(\Exception $e) {
			// Handle exception
			$this->statuscode = $e->getCode();
			echo new Error($e);
		}
		
		// Log & end buffer
		$this->log();
		ob_end_flush();
	}

	/**
	 * Log time & request related data.
	 *
	 * @return void
	 */
	private function log() {
		// Time
		$time = $_SERVER['REQUEST_TIME_FLOAT'];
		$runtime = (microtime(TRUE) - $time) * 1000;
		
		// Request
		$request = $this->pdbc->quote($_SERVER['REQUEST_URI']);
		$referal = empty($_SERVER['HTTP_REFERER']) ? 'NULL' : '"' . $this->pdbc->quote($_SERVER['HTTP_REFERER']) . '"';
		$ip = $this->pdbc->quote($_SERVER['REMOTE_ADDR']);

		// Insert
		$this->pdbc->query('INSERT INTO `log` (`id`,
		                                       `time`,
		                                       `runtime`,
		                                       `bandwidth`,
		                                       `statuscode`,
		                                       `request`,
		                                       `referal`,
		                                       `ip`)
		                    VALUES (           NULL,
		                                       "' . $time . '",
		                                       "' . $runtime . '",
		                                       "' . ob_get_length() . '",
		                                       "' . $this->statuscode . '",
		                                       "' . $request . '",
		                                       ' . $referal . ',
		                                       "' . $ip . '")');
	}
}

?>
