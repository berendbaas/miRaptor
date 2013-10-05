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
	const PAGE_LOGOUT = 'logout';
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
		if($this->user->isLoggedIn()) {
			$this->result =$this->handleAdmin();
		} else {
			$this->result =$this->handleLogin();
		}
	}

	/**
	 *
	 */
	public function handleLogin() {
		if($this->request->getUri()->getFilename() != self::PAGE_LOGIN) {
			$this->redirect(self::PAGE_LOGIN);
		}

		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($this->user->logIn($_POST['username'], $_POST['password'])) {
				$this->redirect(self::PAGE_OVERVIEW);
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
	public function handleAdmin() {
		switch($this->request->getUri()->getFilename()) {
			case self::PAGE_LOGIN:
				$this->redirect(self::PAGE_OVERVIEW);
			break;
			case self::PAGE_LOGOUT:
				return $this->handleLogout();
			break;
			case self::PAGE_OVERVIEW:
				return $this->handleOverview();
			break;
			case self::PAGE_SETTINGS:
				return $this->handleSettings();
			break;
			case self::PAGE_SITE:
				return $this->handleSite();
			break;
			default:
				throw new \Exception('Page not found', 404);
			break;
		}
	}

	/**
	 *
	 */
	private function handleLogout() {
		$this->user->logout();
		$this->redirect(self::PAGE_LOGIN);
	}

	/**
	 *
	 */
	private function handleOverview() {
		return 'TODO overview';
	}

	/**
	 *
	 */
	private function handleSettings() {
		return 'TODO settings';
	}

	/**
	 *
	 */
	private function parseMenuMain() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function handleSite() {
		return 'TODO site';
	}

	/**
	 *
	 */
	private function parseMenuSite() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function redirect($file) {
		throw new \Exception($this->request->getHost() . $this->request->getUri()->getPath() . $file, 301);
	}
}

?>
