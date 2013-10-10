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

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, URL $url, $location) {
		$filename = $location . $url->getDirectory() . ($url->getFile() == '' ? self::DEFAULT_FILE : $url->getFile());

		switch(strtoupper($_SERVER['REQUEST_METHOD'])) {
			case 'GET':
				if(file_exists($filename)) {
					$this->getPage($filename);
					break;
				}

			case 'POST':
				$this->parsePage($pdbc, $url, $filename);
			break;

			default:
				throw new \Exception('Bad request: Method not supported.', 400);
			break;
		}
	}

	/**
	 *
	 */
	private function getPage($filename) {
		// Header parse
		$lastModified = filemtime($filename);

		if(!$this->isModified($lastModified)) {
			throw new \Exception('Not Modified', 304);
		}

		// Header echo
		header('content-type: ' . mime_content_type($filename));
		header('last-modified: ' . gmdate("D, d M Y H:i:s", $lastModified) . " GMT");

		// Content echo
		echo file_get_contents($filename);

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
	private function parsePage(PDBC $pdbc, URL $url, $filename) {
		// Header
		header('content-type: text/html');

		// Content parse
		$parser = new Parser($pdbc, $url);
		$parser->run();

		// Content echo
		echo $parser->__toString();

		// Content cache
		if($parser->isStatic() && MIRAPTOR_CACHE) {
			// Create folder(s)
			$folder = dirname($filename);

			if(!file_exists($folder)) {
				$old = umask(002);
				mkdir($folder, 0775, TRUE);
				umask($old);
			}

			// Create file
			file_put_contents($filename, $parser->__toString());
		}
	}
}

?>
