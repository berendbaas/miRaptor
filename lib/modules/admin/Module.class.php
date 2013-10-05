<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module implements \lib\core\ModuleInterface {
	const USER_DB = 'miraptor_cms';

	const PAGE_LOGIN = '';
	const PAGE_LOGOUT = 'logout'
	const PAGE_OVERVIEW = 'overview';
	const PAGE_SETTINGS = 'settings';
	const PAGE_SITE = 'site';

	private $pdbc;
	private $request;
	private $page;
	private $args;
	private $result;

	private $userPdbc;
        private $user;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\Request $request, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->request = $request;
		$this->page = $page;
		$this->args = $args;
		$this->result = '';

		include('config.php');
		$this->userPdbc = new \lib\core\Mysql($config['mysql']);
		$this->userPdbc->selectDatabase(self::USER_DB);
		$this->user = new \lib\core\User($this->userPdbc);
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->result;
	}

	/**
	 *
	 */
	public function isStatic() {
		return FALSE;
	}

	/**
	 *
	 */
	public function isNamespace() {
		return TRUE;
	}

	/**
	 *
	 */
	public function run() {
		switch($this->request->getUri()->getFilename()) {
			case self::PAGE_LOGIN:
				$this->result = $this->handleLogin();
			break;
			case self::PAGE_LOGOUT:
				$this->result = $this->handleLogout();
			break;
			case self::PAGE_OVERVIEW:
				$this->result = $this->handleOverview();
			break;
			case self::PAGE_SETTINGS:
				$this->result = $this->handleSettings();
			break;
			case self::PAGE_SITE:
				$this->result = $this->handleSite();
			break;
		}
		
		throw new \Exception('File name not supported');
	}

	/**
	 *
	 */
	private function handleLogin() {
		if($this->user->isLoggedIn()) {
			throw new \Exception($this->request->getHost() . $this->request->getUri()->getPath() . self::PAGE_OVERVIEW, 301);
		} else if(isset($_POST['username']) && isset($_POST['password'])) {
			if($this->user->logIn($_POST['username'], $_POST['password'])) {
				throw new \Exception($this->request->getHost() . $this->request->getUri()->getPath() . self::PAGE_OVERVIEW, 301);
			}
		}

		return <<<HTML
<form method="post" action="">
	<label for="username">Username: <input type="text" id="username" name="username" /></label>
	<label for="password">Password: <input type="password" id="password" name="password" /></label>
	<input type='submit' value='login' />
</form>
HTML;
	}

	/**
	 *
	 */
	private function $this->handleLogout() {
		$this->user->logout();
		throw new \Exception($this->request->getHost() . $this->request->getUri()->getPath() . 'login', 301);
	}

	/**
	 *
	 */
	private function $this->handleOverview() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function $this->handleSettings() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function $this->parseMenuMain() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function $this->handleSite() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function $this->parseMenuSite() {
		return 'TODO';
	}
}

?>
