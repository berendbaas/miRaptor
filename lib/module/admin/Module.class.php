<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module implements \lib\core\ModuleInterface {
	const PAGE_LOGIN = '';
	const PAGE_LOGOUT = 'logout';
	const PAGE_OVERVIEW = 'overview';
	const PAGE_SETTINGS = 'settings';
	const PAGE_SITE = 'site';

	private $userPdbc;
        private $user;

	public function __construct(\lib\core\PDBC $pdbc, \lib\core\URL $url, $pageID, array $arguments) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->pageID = $pageID;
		$this->arguments = $arguments;
		$this->result = '';

		include('config.php');
		$this->userPdbc = clone $pdbc;
		$this->userPdbc->selectDatabase($config['pdbc']['database']);
		$this->user = new \lib\core\User($this->userPdbc);
	}

	public function run() {
		if($this->user->isLoggedIn()) {
			$this->result = $this->handleAdmin();
		} else {
			$this->result = $this->handleLogin();
		}
	}

	/**
	 *
	 */
	private function handleAdmin() {
		$result;

		switch($this->url->getFile()) {
			case self::PAGE_LOGIN:
				throw new \Exception($this->url->getURLBase() . self::PAGE_OVERVIEW, 301);
			break;

			case self::PAGE_LOGOUT:
				$result = new ModuleHandleLogout($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			case self::PAGE_OVERVIEW:
				$result = new ModuleHandleOverview($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			case self::PAGE_SETTINGS:
				$result = new ModuleHandleSettings($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			case self::PAGE_SITE:
				$result = new ModuleHandleSite($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			default:
				throw new \Exception('Page not found', 404);
			break;
		}

		return $result->get();
	}

	/**
	 *
	 */
	private function handleLogin() {
		if($this->url->getFile() != Module::PAGE_LOGIN) {
			throw new \Exception($this->url->getURLBase() . Module::PAGE_LOGIN, 301);
		}

		$result = new ModuleHandleLogin($this->userPdbc, $this->url, $this->arguments, $this->user);
		return $result->get();
	}
}

?>