<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class StatusCodeExceptionHandler {
	// Enum
	private $statusCodes = array
	(
		'301' => array
		(
			'phrase' => 'Moved permanently',
			'message' => 'The page has been moved.'
		),

		'302' => array
		(
			'phrase' => 'Found',
			'message' => 'The page has been found.'
		),

		'303' => array
		(
			'phrase' => 'See Other',
			'message' => 'See an other page.'
		),

		'304' => array
		(
			'phrase' => 'Not Modified',
			'message' => 'The page has not been modified.'
		),

		'400' => array
		(
			'phrase' => 'Bad request',
			'message' => 'We don\'t understand what you\'re requesting.'
		),

		'404' => array
		(
			'phrase' => 'Page not found',
			'message' => 'We couldn\'t find the page you were looking for.'
		),

		'500' => array
		(
			'phrase' => 'Service error',
			'message' => 'Sorry, there is something wrong with the service.'
		),

		'501' => array
		(
			'phrase' => 'Not implemented',
			'message' => 'Sorry, we are working on it!'
		)
	);

	private $exception;
	private $statusCode;
	private $phrase;
	private $message;

	/**
	 * Construct a StatusCodeExceptionHandler object with the given exception.
	 *
	 * @param \Exception $exception
	 */
	public function __construct(\Exception $exception) {
		$this->exception = $exception;
		$this->statusCode = array_key_exists($exception->getCode(), $this->statusCodes) ? $exception->getCode() : StatusCodeException::ERROR_SERVER_INTERNAL_SERVER_ERROR;
		$this->phrase = $this->statusCodes[$this->statusCode]['phrase'];
		$this->message = $this->statusCodes[$this->statusCode]['message'];
	}

	/**
	 * Returns the string representation of the StatusCodeExceptionHandler object.
	 *
	 * @return string the string representation of the status code exception handler object.
	 */
	public function __toString() {
		return <<<HTML
<!doctype html>

<html lang="en">

	<head>

		<meta charset="utf-8" />

		<title>miRaptor - {$this->statusCode} {$this->phrase}</title>

		<style>

			body { margin: 25px; padding: 0; font-family: 'Droid Sans', Heveltica, Arial, Tahoma, sans-serif; }

			h1 { margin: 0; padding: 0; font-size: 1.4em; font-weight: normal; }

			p { margin-left: 10px; font-size: 0.9em; line-height: 1.5em; }

			pre { margin-left: 10px; }

		</style>

	</head>

	<body>

		<h1>{$this->statusCode} {$this->phrase}</h1>

		<p>{$this->message}</p>{$this->debug()}

	</body>

</html>
HTML;
	}

	/**
	 * Returns debug information if MIRAPTOR_DEBUG is true.
	 *
	 * @global boolean MIRAPTOR_DEBUG
	 * @return string  debug information if MIRAPTOR_DEBUG is true.
	 */
	private function debug() {
		return !MIRAPTOR_DEBUG ? '' : PHP_EOL . PHP_EOL . <<<HTML
<pre>

{$this->exception->getMessage()}

{$this->exception->getTraceAsString()}

</pre>
HTML;
	}

	/**
	 * Set the correct HTTP headers using the PHP header() method.
	 *
	 * @return void
	 */
	public function setHeader() {
		header($this->phrase, TRUE, $this->statusCode);

		if(floor(($this->statusCode) / 100) == 3) {
			header('Location: ' . $this->exception->getMessage());
		}
	}
}

?>