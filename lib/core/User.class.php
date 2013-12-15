<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class User {
	const SESSION_KEY = 'miraptor_user';

	private $pdbc;
	private $session;
	private $user;

	/**
	 * Construct a User object.
	 *
	 * This object manages the session of the user.
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc) {
		$this->pdbc = $pdbc;
		$this->session = new Session();
		$this->user = $this->session->get(self::SESSION_KEY);
	}

	/**
	 * Destruct the User object.
	 *
	 * Only one script can use the Session class at a time. You can use this to improve performance.
	 */
	public function __destruct() {
		$this->session->set(self::SESSION_KEY, $this->user);
		$this->session->__destruct();
	}

	/**
	 * Sign the current user out.
	 *
	 * @return void
	 */
	public function signOut() {
		$this->user = NULL;
	}

	/**
	 * Returns true if the user is signed in.
	 *
	 * @return boolean true if the user is signed in.
	 */
	public function isSignedIn() {
		return $this->user !== NULL;
	}

	/**
	 * Returns true if you can sign in with the given credentials.
	 * 
	 * @param  string  $username
	 * @param  string  $password
	 * @return boolean true if you can sign in with the given credentials.
	 */
	public function signIn($username, $password) {
		$this->pdbc->query('SELECT `id`, `username`, `password`, `directory`, `name`, `email`
		                    FROM `user`
		                    WHERE `username` = "' . $this->pdbc->quote($username) . '"');

		$user = $this->pdbc->fetch();

		if($user === NULL || !password_verify($password, $user['password'])) {
			return FALSE;
		}

		$this->user = $user;
		return TRUE;
	}

	/**
	 * Returns true if you can change the password of the current user.
	 *
	 * @param  string  $password
	 * @return boolean true if you can change the password of the current user.
	 */
	public function changePassword($password) {
		if(!$this->isSignedIn()) {
			return FALSE;
		}

		$hash = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

		if(!$hash) {
			return FALSE;
		}

		$this->pdbc->query('UPDATE `user` SET `password` = "' . $hash . '" WHERE `id` = "' . $this->user['id'] . '"');

		return TRUE;
	}

	/**
	 * Returns the users ID.
	 *
	 * @return string the users ID.
	 */
	public function getID() {
		return isset($this->user['id']) ? $this->user['id'] : NULL;
	}

	/**
	 * Returns the users username.
	 *
	 * @return string the users username.
	 */
	public function getUsername() {
		return isset($this->user['username']) ? $this->user['username'] : NULL;
	}

	/**
	 * Returns the users directory.
	 *
	 * @return string the users directory.
	 */
	public function getDirectory() {
		return isset($this->user['directory']) ? $this->user['directory'] : NULL;
	}

	/**
	 * Returns the users name.
	 *
	 * @return string the users name.
	 */
	public function getName() {
		return isset($this->user['name']) ? $this->user['name'] : NULL;
	}

	/**
	 * Returns the users email.
	 *
	 * @return string the users email.
	 */
	public function getEmail() {
		return isset($this->user['email']) ? $this->user['email'] : NULL;
	}
}

?>
