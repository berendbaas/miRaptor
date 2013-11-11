<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	const PAGE_SIGN_IN = '';
	const PAGE_SIGN_OUT = 'signout';
	const PAGE_DASHBOARD = 'dashboard';
	const PAGE_ACCOUNT = 'account';
	const PAGE_SITE = 'site';

	private static $userPdbc;
	private static $user;

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, $routerID, array $arguments) {
		parent::__construct($pdbc, $url, $routerID, $arguments);
		$this->isNamespace = TRUE;

		if(!isset($this->userPdbc)) {
			include('config.php');
			$this->userPdbc = clone $pdbc;
			$this->userPdbc->selectDatabase($config['pdbc']['database']);
			$this->user = new \lib\core\User();
		}
	}

	public function run() {
		$this->result = $this->user->isLoggedIn() ? $this->handleAdmin() : $this->handleLogin();
	}

	/**
	 *
	 */
	private function handleAdmin() {
		$result;

		switch($this->url->getFile()) {
			case self::PAGE_SIGN_OUT:
				$result = new ModulePageSignOut($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			case self::PAGE_DASHBOARD:
				$result = new ModulePageDashboard($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			case self::PAGE_ACCOUNT:
				$result = new ModulePageAccount($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			case self::PAGE_SITE:
				$result = new ModulePageSite($this->userPdbc, $this->url, $this->arguments, $this->user);
			break;

			default:
				throw new \lib\core\StatusCodeException($this->url->getURLDirectory() . self::PAGE_DASHBOARD, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			break;
		}

		return $result->get();
	}

	/**
	 *
	 */
	private function handleLogin() {
		if($this->url->getFile() != self::PAGE_SIGN_IN) {
			throw new \lib\core\StatusCodeException($this->url->getURLDirectory() . self::PAGE_SIGN_IN, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$result = new ModulePageSignIn($this->userPdbc, $this->url, $this->arguments, $this->user);

		return $result->get();
	}
}

?>