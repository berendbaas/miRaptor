<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class StatusCodeException extends \Exception {
	const SUCCESFULL_OK = 200;
	const REDIRECTION_MOVED_PERMANENTLY = 301;
	const REDIRECTION_FOUND = 302;
	const REDIRECTION_SEE_OTHER = 303;
	const REDIRECTION_NOT_MODIFIED = 304;
	const ERROR_CLIENT_BAD_REQUEST = 400;
	const ERROR_CLIENT_NOT_FOUND = 404;
	const ERROR_SERVER_INTERNAL_SERVER_ERROR = 500;
	const ERROR_SERVER_NOT_IMPLEMENTED = 501;

	public function __construct($message = '', $code = self::ERROR_SERVER_INTERNAL_SERVER_ERROR, \Exception $previous = NULL) {
		parent::__construct($message, $code, $previous);
	}
}

?>