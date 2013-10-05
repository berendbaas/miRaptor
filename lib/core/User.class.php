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
	private $credentials = array();
	private $userID;

	public function __construct(PDBC $pdbc) {
		$this->pdbc = $pdbc;

		session_start();

		if (isset($_SESSION['USER_ID'])) {
			$this->userID = $this->pdbc->quote($_SESSION['USER_ID']);
		}

		$this->credentials = $this->pdbc->fetch('
			SELECT * FROM user where ID = "' . $this->userID . '"
			');
	}

	/**
	 * Attempts to login the user with the given credentials
	 * @param  String $username 
	 * @param  String $password 
	 * @return boolean           true if succesful, false on fail.
	 */
	public function logIn($username, $password) {
		$username = $this->pdbc->quote($username);
		$password = $this->pdbc->quote($password);

		$test = end($this->pdbc->fetch('
				SELECT *
				FROM user
				WHERE
					username = "' . $username . '"
					AND password = "' . $password . '"
			'));
		if (!empty($test)) {
			$this->userID = $test['id'];
			$_SESSION['USER_ID'] = $test['id'];
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Logs out the currently logged in user
	 * @return void
	 */
	public function logOut() {
		$this->userID = null;
		unset($_SESSION['USER_ID']);
	}

	/**
	 * Checks if the user is currently logged in
	 * @return boolean login-status
	 */
	public function isLoggedIn() {
		return isset($this->userID);
	}


	/**
	 * Get a credential from the user
	 * @param  String $key 
	 * @return mixed
	 */
	public function getCredential($key) {
		return $this->credentials[$key];
	}

	/**
	 * Sets a credential to the current
	 * @param string $key   the column to reference in the row
	 * @param mixed $value  should be the correct mysql type.
	 */
	public function setCredential($key, $value) {
		$column = $pdbc->quote($key);
		$field = $pdbc->quote($value);

		$pdbc->execute('UDPATE `user` 
			set "' . $column . '" = "' . $value .'"
			where id="' . $this->userID . '"');
	}
}

?>
