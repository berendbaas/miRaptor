<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	const DEFAULT_NAMESPACE = ModulePageAbstract::DEFAULT_NAMESPACE;

	const PAGE_SIGN_IN = 'signin';
	const PAGE_SIGN_OUT = 'signout';
	const PAGE_ACCOUNT = 'account';
	const PAGE_DASHBOARD = 'dashboard';
	const PAGE_WEBSITE = 'website';

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\util\URL $url, $routerID, array $arguments) {
		parent::__construct($pdbc, $url, $routerID, $arguments);

		$this->pdbc = clone $pdbc;
		$this->pdbc->selectDatabase(MIRAPTOR_DB);
	}

	public function run() {
		$page;

		switch($this->parseGet()) {
			case self::PAGE_SIGN_IN:
				$page = new ModulePageSignIn($this->pdbc, $this->url, $this->parseRedirect());
			break;

			case self::PAGE_SIGN_OUT:
				$page = new ModulePageSignOut($this->pdbc, $this->url, $this->parseRedirect());
			break;

			case self::PAGE_ACCOUNT:
				$page = new ModulePageAccount($this->pdbc, $this->url, $this->parseRedirect());
			break;

			case self::PAGE_DASHBOARD:
				$page = new ModulePageDashboard($this->pdbc, $this->url, $this->parseRedirect(), $this->parseWebsite());
			break;

			case self::PAGE_WEBSITE:
				$page = new ModulePageWebsite($this->pdbc, $this->url, $this->parseRedirect());
			break;

			default:
				throw new \lib\core\ModuleException('get="' . $this->arguments['get']. '" is not supported.');
			break;
		}

		$page->run();
		$this->isNamespace = $page->isNamespace();
		$this->result = $page->__toString();
	}

	/**
	 * Returns the get argument, if one is given.
	 *
	 * @return string                    the get argument, if one is given.
	 * @throws \lib\core\ModuleException if the get argument isn't given.
	 */
	private function parseGet() {
		if(isset($this->arguments['get'])) {
			return $this->arguments['get'];
		}

		throw new \lib\core\ModuleException('get="" required.');
	}

	/**
	 * Returns the redirect argument, if one is given.
	 *
	 * @return string                    the redirect argument, if one is given.
	 * @throws \lib\core\ModuleException if the redirect argument isn't given.
	 */
	private function parseRedirect() {
		if(isset($this->arguments['redirect'])) {
			return $this->arguments['redirect'];
		}

		throw new \lib\core\ModuleException('redirect="" required.');
	}

	/**
	 * Returns the website argument, if one is given.
	 *
	 * @return string                    the website argument, if one is given.
	 * @throws \lib\core\ModuleException if the website argument isn't given.
	 */
	private function parseWebsite() {
		if(isset($this->arguments['website'])) {
			return $this->arguments['website'];
		}

		throw new \lib\core\ModuleException('website="" required.');
	}
}

?>