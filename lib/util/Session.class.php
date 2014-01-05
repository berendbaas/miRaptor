<?php
namespace lib\util;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Session {
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
	 * Returns true if this session map contains a mapping for the specified key.
	 *
	 * @param  String  $key
	 * @return boolean true if this session map contains a mapping for the specified key.
	 */
	public function containsKey($key) {
		return isset($_SESSION[$key]);
	}

	/**
	 * Returns true if this session map maps one or more keys to the specified value.
	 *
	 * @param  String  $key
	 * @return boolean true if this session map maps one or more keys to the specified value.
	 */
	public function containsValue($value) {
		return in_array($value, $_SESSION);
	}

	/**
	 * Returns the value to which the specified key is mapped, or null if this session map contains no mapping for the key.
	 *
	 * @param  String $key
	 * @return String the value to which the specified key is mapped, or null if this session map contains no mapping for the key.
	 */
	public function get($key) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}

	/**
	 * Removes the mapping for the specified key from this session map if present.
	 *
	 * @param  String $key
	 * @return void
	 */
	public function remove($key) {
		unset($_SESSION[$key]);
	}

	/**
	 * Associates the specified value with the specified key in this session map.
	 *
	 * @param  String $key
	 * @param  String $value
	 * @return void
	 */
	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}
}

?>
