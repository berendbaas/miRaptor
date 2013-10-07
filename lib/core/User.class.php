<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class User {
	private $pdbc;

	/**
	 * Construct a session object to manage the session of the user.
	 *
	 * @param PDBC $pdbc
	 */
	public function __construct(PDBC $pdbc) {
		$this->pdbc = $pdbc;
		session_start();
	}

	/**
	 * Only one script can use session at a time. Use this to improve performance.
	 */
	public function __destruct() {
		session_write_close();
	}

	/**
	 * Attempts to login the user with the given credentials
	 *
	 * @param  String $username 
	 * @param  String $password 
	 * @return boolean true if succesful, false on fail.
	 */
	public function login($username, $password) {
		$this->pdbc->query('SELECT `id`
		                    FROM user
		                    WHERE username = "' . $this->pdbc->quote($username) . '"
		                    AND password = "' . $this->pdbc->quote($password) . '"');

		$user = $this->pdbc->fetch();

		if(empty($user)) {
			return false;
		}

		$_SESSION['id'] = $user['id'];
		return true;
	}

	/**
	 * Logout the user if the user is logged in.
	 *
	 * @return void
	 */
	public function logout() {
		unset($_SESSION['id']);
	}

	/**
	 * Returns true if the user is logged in
	 *
	 * @return boolean true if the user is logged in.
	 */
	public function isLoggedIn() {
		return isset($_SESSION['id']);
	}

	/**
	 * Returns the user ID if the user is logged in or 0 if the user is not logged in.
	 *
	 * @return boolean the user ID if the user is logged in or 0 if the user is not logged in.
	 */
	public function getID() {
		return $this->isLoggedIn() ? $_SESSION['id'] : 0;
	}
}

?>
