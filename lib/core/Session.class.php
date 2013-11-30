<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Session {
	const SIGN_IN = 'signin';

	/**
	 * Construct a Session object.
	 *
	 * This object manages the session of the user.
	 */
	public function __construct() {
		session_start();
	}

	/**
	 * Destruct the Session object.
	 *
	 * Only one script can use session at a time. You can use this to improve performance.
	 */
	public function __destruct() {
		session_write_close();
	}

	/**
	 * Sign In.
	 *
	 * @return void
	 */
	public function signIn() {
		$_SESSION[self::SIGN_IN] = TRUE;
	}

	/**
	 * Sign Out.
	 *
	 * @return void
	 */
	public function signOut() {
		unset($_SESSION[self::SIGN_IN]);
	}

	/**
	 * Returns true if the user is singed in.
	 *
	 * @return boolean true if the user is signed in.
	 */
	public function isSignedIn() {
		return isset($_SESSION[self::SIGN_IN]);
	}

	/**
	 * Set the given key with the given value in the session data.
	 *
	 * ATTENTION: using Session::SIGN_IN as $key might result in unexpected behavior.
	 *
	 * @param  String $key
	 * @param  String $value
	 * @return void
	 */
	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * Return the session value with the given key.
	 *
	 * @param  String $key
	 * @return String the session value with the given key.
	 */
	public function get($key) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}
}

?>
