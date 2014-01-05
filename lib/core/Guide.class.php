<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Guide implements Runnable {
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';

	private $pdbc;
	private $url;
	private $filename;

	/**
	 * Construct a Guide object with the given PDBC, URL & folder.
	 *
	 * @param  \lib\pdbc\PDBC $pdbc
	 * @param  URL            $url
	 * @param  string         $folder
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url, File $file) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->file = $file;
	}

	public function run() {
		switch(strtoupper($_SERVER['REQUEST_METHOD'])) {
			case self::METHOD_GET:
				if($this->file->exists()) {
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
	 * @throws StatusCodeException if the requested file isn't modified.
	 */
	private function getPage() {
		// Header parse
		$lastModified = $this->file->lastModified();

		if(!$this->isModified($lastModified)) {
			throw new StatusCodeException('Guide: Page not Modified', StatusCodeException::REDIRECTION_NOT_MODIFIED);
		}

		// Header echo
		header('content-type: ' . mime_content_type($this->file->getPath()));
		header('last-modified: ' . gmdate("D, d M Y H:i:s", $lastModified) . " GMT");

		// Content echo
		echo file_get_contents($this->file->getPath());

	}

	/**
	 * Returns true if the file is modified.
	 *
	 * @param  int     $lastModified
	 * @return boolean true if the file is modified.
	 */
	private function isModified($lastModified) {
		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) === $lastModified) {
			return false;
		}

		return true;
	}

	/**
	 * Echos the dynamic page.
	 *
	 * @global boolean                 MIRAPTOR_CACHE
	 * @return void
	 * @throws StatusCodeException     if the requested file can't be parsed.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private function parsePage() {
		// Header
		header('content-type: text/html');

		// Content parse
		$module = isset($_SERVER['HTTP_X_MIRAPTOR_AJAX']) ? $_SERVER['HTTP_X_MIRAPTOR_AJAX'] : Parser::DEFAULT_MODULE;
		$parser = new Parser($this->pdbc, $this->url, $module);
		$parser->run();

		// Check namespacing
		if(!$parser->isNamespace() && $this->url->getFile() !== '') {
			throw new StatusCodeException('Guide: Namespacing requested, but not used - ' . $this->url->getPath(), StatusCodeException::ERROR_CLIENT_NOT_FOUND);
		}

		// Content echo
		echo $parser->__toString();

		// Content cache
		if($parser->isStatic() && MIRAPTOR_CACHE) {
			// Create folder(s)
			$folder = dirname($this->file->getPath());

			if(!file_exists($folder)) {
				$old = umask(002);
				mkdir($folder, 0775, TRUE);
				umask($old);
			}

			// Create file
			file_put_contents($this->file->getPath(), $parser->__toString());
		}
	}
}

?>
