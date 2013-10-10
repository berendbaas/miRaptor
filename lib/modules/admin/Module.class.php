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
	private $url;
	private $page;
	private $args;
	private $result;

	private $userPdbc;
        private $user;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\URL $url, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->url = $url;
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
			if(isset($this->args['get'])) {
				switch($this->args['get']) {
					case 'logbox':
						$this->result = $this->handleLogBox();
					break;
					case 'menu':
						$this->result = $this->handleMenu();
					break;
				}
			} else {
				$this->result = $this->handleAdmin();
			}
		} else {
			if(isset($this->args['get'])) {
				$this->result = '';
			} else {
				$this->result = $this->handleLogin();
			}
		}
	}

	/**
	 *
	 */
	private function handleLogin() {
		if($this->url->getFile() != self::PAGE_LOGIN) {
			throw new \Exception($this->url->getURLBase() . self::PAGE_LOGIN, 301);
		}

		$message = '';

		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($this->user->login($_POST['username'], $_POST['password'])) {
				throw new \Exception($this->url->getURLBase() . self::PAGE_OVERVIEW, 301);
			}

			$message = <<<HTML
<p class="error">Invalid username or password.</p>
HTML;
		}

		return $message . <<<HTML
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
	private function handleAdmin() {
		switch($this->url->getFile()) {
			case self::PAGE_LOGIN:
				throw new \Exception($this->url->getURLBase() . self::PAGE_OVERVIEW, 301);
			break;

			case self::PAGE_LOGOUT:
				return $this->handleLogout();
			break;

			case self::PAGE_OVERVIEW:
				$result = new ModuleOverview($this->pdbc, $this->url, $this->userPdbc, $this->user);
				return $result->get();
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
		throw new \Exception($this->url->getURLBase() . self::PAGE_LOGIN, 301);
	}

	/**
	 *
	 */
	private function handleSettings() {
		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'changepassword':
					return $this->handleChangePassword();
					break;
				
				case 'changeemail':
					return $this->handleChangeEmail();
					break;
			}
		}
		return $this->handleSettingsDefault();
	}


	private function handleSettingsDefault() {
		$result = <<<HTML
<tr>
	<td><a href="?action=changepassword"> Change Password</a></td>
	<td><a href="?action=changeemail"> Change E-mail adress</a></td>
</tr>
HTML;
		return $result;
	}

	private function handleChangePassword() {
		$message = '';

		if (isset($_POST['password'])) {
			$this->userPdbc->query('UPDATE `user`
									SET `password` = "' . $this->userPdbc->quote($_POST['password']) . '"
									WHERE `id` = "' . $this->userPdbc->quote($this->user->getID()) . '"');
			if ($this->userPdbc->rowCount() > 0) {
				throw new \Exception($this->url->getURLBase() . self::SETTINGS, 301);
			}
			else {
				$message .= <<<HTML
<p class="error">Can't change password.</p>
HTML;
			}
		}

		$cancel= $this->url->getDirectory() . self::PAGE_SETTINGS;
		$result = <<<HTML
<form action="" method="POST">
	<label for="password"><input type="password" name="password">
	<input type="submit"><a href="{$cancel}">Back</a>
</form>
HTML;

	return $message . $result;
	}

	private function handleChangeEmail() {
		$message = '';

		if (isset($_POST['email'])) {
			$this->userPdbc->query('UPDATE `user`
									SET `email` = "' . $this->userPdbc->quote($_POST['email']) . '"
									WHERE `id` = "' . $this->userPdbc->quote($this->user->getID()) . '"');
			if ($this->userPdbc->rowCount() >0) {
				throw new \Exception($this->url->getURLBase() . self::PAGE_SETTINGS, 301);
			}
			else {
				$message .= <<<HTML
<p class="error">Can't change email</p>
HTML;
			}
		}
		$cancel = $this->url->getDirectory() . self::PAGE_SETTINGS;
		$form = <<<HTML
<form action="" method="POST">
	<label for="email"><input type="text" name="email">
	<input type="submit"><a href="{$cancel}">Back</a>
</form>
HTML;

	return $message . $form;
	}

	/**
	 *
	 */
	private function handleSite() {
/* If()
 * 	Geen id terug naar overview
 * 	Geen mid laat alle modules zien in een lijst of iets dergelijks!
 *	Roep de bij behorende admin van de module aan.
 *
 * Update AdminInterface URI class -> Request class
 * Eventueel de GET class meegeven die we ook in de admin gaan gebruiken.
 */
		return 'TODO site';
	}

	/**
	 *
	 */
	private function handleMenu() {
		switch($this->url->getFile()) {
			case self::PAGE_LOGIN:
				return $this->parseMenuLogin();
			break;

			case self::PAGE_LOGOUT:
				return $this->parseMenuLogout();
			break;

			case self::PAGE_OVERVIEW:
				return $this->parseMenuOverview();
			break;

			case self::PAGE_SETTINGS:
				return $this->parseMenuSettings();
			break;

			case self::PAGE_SITE:
				return $this->parseMenuSite();
			break;
		}
	}

	/**
	 *
	 */
	private function parseMenuLogin() {
		return '';
	}

	/**
	 *
	 */
	private function parseMenuLogout() {
		return $this->parseMenuLogin();
	}

	/**
	 *
	 */
	private function parseMenuOverview() {
		$overview = $this->url->getDirectory() . self::PAGE_OVERVIEW;
		$settings = $this->url->getDirectory() . self::PAGE_SETTINGS;

		return <<<HTML
<ul>
<li><a href="{$overview}">Overview</a></li>
<li><a href="{$settings}">Settings</a></li>
</ul>
HTML;
	}

	/**
	 *
	 */
	private function parseMenuSettings() {
		return $this->parseMenuOverview();
	}

	/**
	 *
	 */
	private function parseMenuSite() {
		return 'TODO Website menu';
	}

	/**
	 *
	 */
	private function handleLogBox() {
		switch($this->url->getFile()) {
			case self::PAGE_LOGIN:
				return $this->parseLogBoxLogin();
			break;

			case self::PAGE_LOGOUT:
				return $this->parseLogBoxLogout();
			break;

			case self::PAGE_OVERVIEW:
				return $this->parseLogBoxOverview();
			break;

			case self::PAGE_SETTINGS:
				return $this->parseLogBoxSettings();
			break;

			case self::PAGE_SITE:
				return $this->parseLogBoxSite();
			break;
		}
	}

	/**
	 *
	 */
	private function parseLogBoxLogin() {
		return <<<HTML
HTML;
	}

	/**
	 *
	 */
	private function parseLogBoxLogout() {
		return $this->parseLogBoxLogin();
	}

	/**
	 *
	 */
	private function parseLogBoxOverview() {
		$logout = $this->url->getDirectory() . self::PAGE_LOGOUT;

		return <<<HTML
<ul>
<li><a href="{$logout}">Logout</a></li>
</ul>
HTML;
	}

	/**
	 *
	 */
	private function parseLogBoxSettings() {
		return $this->parseLogBoxOverview();
	}

	/**
	 *
	 */
	private function parseLogBoxSite() {
		$overview = $this->url->getDirectory() . self::PAGE_OVERVIEW;
		$logout = $this->url->getDirectory() . self::PAGE_LOGOUT;

		return <<<HTML
<ul>
<li><a href="{$overview}">Overview</a></li>
<li><a href="{$logout}">Logout</a></li>
</ul>
HTML;
	}
}

?>