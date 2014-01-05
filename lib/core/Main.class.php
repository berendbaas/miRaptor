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
	private $userDirectory;
	private $statusCode;

	/**
	 * Construct a Main object with the given PDBC object, default host & user folder.
	 *
	 * @param  PDBC   $config
	 * @param  String $defaultHost
	 * @param  String $userDirectory
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, $defaultHost, $userDirectory) {
		$this->pdbc = $pdbc;
		$this->url = self::initURL($defaultHost);
		$this->userDirectory = $userDirectory;
		$this->statusCode = StatusCodeException::SUCCESFULL_OK;
	}

	/**
	 * Returns a URL object.
	 *
	 * @param  string $defaultHost
	 * @return URL    a URL object.
	 */
	public static function initURL($defaultHost) {
		$scheme = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$host = empty($_SERVER['HTTP_HOST']) ? $defaultHost : $_SERVER['HTTP_HOST'];

		return new URL($scheme . $host . $_SERVER['REQUEST_URI']);
	}

	public function run() {
		// start buffer
		ob_start();

		try {
			// Gatekeeper
			$gatekeeper = new Gatekeeper($this->pdbc, $this->url, $this->userDirectory);
			$this->pdbc = $gatekeeper->getPDBC();

			// Guide
			$guide = new Guide($this->pdbc, $this->url, $gatekeeper->getFile());
			$guide->run();
		} catch(StatusCodeException $e) {
			$this->statusCode = $e->getCode();

			$handler = new StatusCodeExceptionHandler($e);
			$handler->setHeader();
			echo $handler;
		} catch(\Exception $e) {
			$this->statusCode = StatusCodeException::ERROR_SERVER_INTERNAL_SERVER_ERROR;

			$handler = new StatusCodeExceptionHandler($e);
			$handler->setHeader();
			echo $handler;
		}
		
		// Log & end buffer
		$this->log();
		ob_end_flush();
	}

	/**
	 * Log time & request related data.
	 *
	 * @return void
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private function log() {
		// Run time
		$runtime = (microtime(TRUE) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000;
		
		// Request
		$request = $this->pdbc->quote($this->url->getURL());
		$referal = empty($_SERVER['HTTP_REFERER']) ? 'NULL' : '"' . $this->pdbc->quote($_SERVER['HTTP_REFERER']) . '"';
		$ip = $this->pdbc->quote($_SERVER['REMOTE_ADDR']);

		// Insert
		$this->pdbc->query('INSERT INTO `log` (`date`, `runtime`, `bandwidth`, `statuscode`, `request`, `referal`, `ip`)
		                    VALUES (FROM_UNIXTIME("' . $_SERVER['REQUEST_TIME_FLOAT'] . '"),
		                            "' . $runtime . '",
		                            "' . ob_get_length() . '",
		                            "' . $this->statusCode . '",
		                            "' . $request . '",
		                            ' . $referal . ',
		                            "' . $ip . '")');
	}
}

?>
