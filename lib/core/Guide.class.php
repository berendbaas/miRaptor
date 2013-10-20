<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Guide implements Runnable {
	const DEFAULT_FILE = 'index.html';
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';

	private $pdbc;
	private $url;
	private $filename;

	/**
	 * Construct a Guide object with the given PDBC, URL & location.
	 *
	 * @param  \lib\pdbc\PDBC $pdbc
	 * @param  URL            $url
	 * @param  string         $location
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url, $location) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->filename = $location . $url->getDirectory() . ($url->getFile() == '' ? self::DEFAULT_FILE : $url->getFile());
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
				throw new StatusCodeException('Guide: Method not supported.', StatusCodeException::ERROR_CLIENT_BAD_REQUEST);
			break;
		}
	}

	/**
	 * Echos the static page.
	 *
	 * @return void
	 * @throws StatusCodeException on failure.
	 * @throws PDBCException   on PDBC failure.
	 */
	private function getPage() {
		// Header parse
		$lastModified = filemtime($this->filename);

		if(!$this->isModified($lastModified)) {
			throw new StatusCodeException('Guide: Page not Modified', StatusCodeException::REDIRECTION_NOT_MODIFIED);
		}

		// Header echo
		header('content-type: ' . mime_content_type($this->filename));
		header('last-modified: ' . gmdate("D, d M Y H:i:s", $lastModified) . " GMT");

		// Content echo
		echo file_get_contents($this->filename);

	}

	/**
	 * Returns true if the file is modified.
	 *
	 * @return boolean true if the file is modified.
	 */
	private function isModified($lastModified) {
		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified) {
			return false;
		}

		return true;
	}

	/**
	 * Echos the dynamic page.
	 *
	 * @global boolean             MIRAPTOR_CACHE
	 * @return void
	 * @throws StatusCodeException on failure.
	 * @throws PDBCException   on PDBC failure.
	 */
	private function parsePage() {
		// Header
		header('content-type: text/html');

		// Content parse
		$parser = new Parser($this->pdbc, $this->url);
		$parser->run();

		// Check namespacing
		if(!$parser->isNamespace() && $this->url->getFile() != '') {
			throw new StatusCodeException('Guide: Namespacing requested, but not used - ' . $this->url->getPath(), StatusCodeException::ERROR_CLIENT_NOT_FOUND);
		}

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
