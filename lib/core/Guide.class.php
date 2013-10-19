<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Guide {
	const DEFAULT_FILE = 'index.html';
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';

	private $pdbc;
	private $url;
	private $filename;

	/**
	 *
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url, $location) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->filename = $location . $url->getDirectory() . ($url->getFile() == '' ? self::DEFAULT_FILE : $url->getFile());
		$this->run();
	}

	public function run() {
		switch(strtoupper($_SERVER['REQUEST_METHOD'])) {
			case self::METHOD_GET:
				if(file_exists($this->filename)) {
					$this->getPage();
					break;
				}

			case self::METHOD_POST:
				$this->parsePage();
			break;

			default:
				throw new \Exception('Bad request: Method not supported.', 400);
			break;
		}
	}

	/**
	 *
	 */
	private function getPage() {
		// Header parse
		$lastModified = filemtime($this->filename);

		if(!$this->isModified($lastModified)) {
			throw new \Exception('Not Modified', 304);
		}

		// Header echo
		header('content-type: ' . mime_content_type($this->filename));
		header('last-modified: ' . gmdate("D, d M Y H:i:s", $lastModified) . " GMT");

		// Content echo
		echo file_get_contents($this->filename);

	}

	/**
	 *
	 */
	private function isModified($lastModified) {
		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			if(strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified) {
				return false;
			}
		}

		return true;
	}

	/**
	 *
	 */
	private function parsePage() {
		// Header
		header('content-type: text/html');

		// Content parse
		$parser = new Parser($this->pdbc, $this->url);
		$parser->run();

		// Content echo
		echo $parser->__toString();

		// Content cache
		if($parser->isStatic() && MIRAPTOR_CACHE) {
			// Create folder(s)
			$folder = dirname($this->filename);

			if(!file_exists($folder)) {
				$old = umask(002);
				mkdir($folder, 0775, TRUE);
				umask($old);
			}

			// Create file
			file_put_contents($this->filename, $parser->__toString());
		}
	}
}

?>
