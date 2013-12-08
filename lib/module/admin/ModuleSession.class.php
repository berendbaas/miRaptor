<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleSession {
	const USER_ID = 'user_id';

	private $pdbc;
	private $session;

	/**
	 *
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc) {
		$this->pdbc = $pdbc;
		$this->session = new \lib\core\Session();
	}

	/**
	 *
	 */
	public function isSignedIn() {
		return $this->session->containsKey(self::USER_ID);
	}

	/**
	 *
	 */
	public function signIn($username, $password) {
		$this->pdbc->query('SELECT `id`
		              FROM user
		              WHERE `username` = "' . $this->pdbc->quote($username) . '"
		              AND `password` = "' . $this->pdbc->quote($password) . '"');

		if(!$this->pdbc->rowCount()) {
			return FALSE;
		}

		$this->session->set(self::USER_ID, end($this->pdbc->fetch()));
		return TRUE;
	}

	/**
	 *
	 */
	public function signOut() {
		$this->session->remove(self::USER_ID);
	}

	/**
	 *
	 */
	public function getUserID() {
		return $this->session->containsKey(self::USER_ID) ? $this->session->get(self::USER_ID) : 0;
	}

	/**
	 *
	 */
	public function hasAccessWebsite($id) {
		if(!$this->session->containsKey(self::USER_ID)) {
			return FALSE;
		}

		$this->pdbc->query('SELECT `name`
		                    FROM `website`
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->session->get(self::USER_ID)) . '"');

		return $this->pdbc->fetch() !== NULL;
	}
}

?>
