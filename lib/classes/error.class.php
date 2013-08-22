<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Error {
	const DEFAULT_ERROR = 500;

	private $exception;

	private $error;
	private $errors = array
	(
		'301' => array
		(
			'statuscode' => '301',
			'title' => 'Moved permanently',
			'description' => 'The page moved, that\'s all we know.'
		),

		'304' => array
		(
			'statuscode' => '304',
			'title' => 'Not Modified',
			'description' => 'The page has not been modified.'
		),

		'400' => array
		(
			'statuscode' => '400',
			'title' => 'Bad request',
			'description' => 'We don\'t understand what you\'re requesting.'
		),

		'404' => array
		(
			'statuscode' => '404',
			'title' => 'Page not found',
			'description' => 'We couldn\'t find the page you were looking for. Sorry! :('
		),

		'500' => array
		(
			'statuscode' => '500',
			'title' => 'Service error',
			'description' => 'There is something wrong with the service. Sorry! :('
		)
	);

	/**
	 *
	 */
	public function __construct(Exception $exception) {
		$this->exception = $exception;
		$this->error = empty($this->errors[$exception->getCode()]) ? $this->errors[self::DEFAULT_ERROR] : $this->errors[$exception->getCode()] ;
	}

	/**
	 *
	 */
	public function __toString() {
		// Header
		header($this->error['title'], TRUE, $this->error['statuscode']);

		if($this->error['statuscode'] == 301) {
			header('Location: http://' . $this->exception->getMessage());
		}

		// Content
		return 
"<!doctype html>

<html lang='en'>

	<head>

		<meta charset='utf-8' />

		<title>miRaptor - " . $this->error['title'] . "</title>

		<style>

			body{ margin: 25px; padding: 0; }
			h1, p{ font-family: 'Droid Sans', Heveltica, Arial, Tahoma, sans-serif; }
			p{ font-size: 0.9em; line-height: 1.5em; margin-left: 10px; }
			h1{ font-size: 1.4em; margin: 0; padding: 0; font-weight: normal; }

		</style>

	</head>

	<body>

		<h1>" . $this->error['title'] . "</h1>

		<p>" . $this->error['description'] . "</p>" . (MIRAPTOR_DEBUG ? PHP_EOL . PHP_EOL . '		<pre>' . $this->exception->getMessage() . '</pre>' . PHP_EOL . PHP_EOL . '		<pre>' . $this->exception->getTraceAsString() . '</pre>' : '') . "

	</body>

</html>";
	}
}

?>