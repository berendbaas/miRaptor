<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Guide {
	/**
	 *
	 */
	public function __construct(PDBC $pdbc, Request $request, $location) {
		$filename = $location . $request->getUri()->getPath();

		switch($request->getMethod()) {
			case 'get':
				// index.html
				if(substr($filename, -1) == '/') {
					$filename .= 'index.html';
				}

				// Check if the file exists
				if(file_exists($filename)) {
					$this->getRequest($filename);
					break;
				}

			case 'post':
				$this->parseRequest($pdbc, $request, $filename);
			break;

			defaut:
				throw new Exception('Bad request: Method not supported.', 400);
			break;
		}
	}

	/**
	 *
	 */
	private function getRequest($filename) {
		// Header parse
		$lastModified = filemtime($filename);

		if(!$this->isModified($lastModified)) {
			throw new Exception('Not Modified', 304);
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
	private function parseRequest(PDBC $pdbc, Request $request, $filename) {
		// Header
		header('content-type: text/html');

		// Content parse
		$parser = new Parser($pdbc, $request);
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
