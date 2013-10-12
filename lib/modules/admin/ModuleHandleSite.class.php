<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleSite extends ModuleHandleAbstract {
	const ADMIN_CLASS = '\\Admin';
	const ADMIN_NAMESPACE = 'lib\\modules\\';

	/**
	 *
	 */
	public function content() {
		if(isset($_GET['id']) && $this->hasAccess() && isset($_GET['module']) && $this->moduleExists()) {
			$module = self::ADMIN_NAMESPACE . $_GET['module'] . self::ADMIN_CLASS;

			$result = new $module($this->pdbc, $this->url);
			$result->run();

			return $result->__toString();
		}

		return 'Overzicht';

		// throw new \Exception($this->url->getURLBase() . Module::PAGE_OVERVIEW, 301);
	}

	/**
	 *
	 */
	public function hasAccess() {
		return TRUE;
	}

	/**
	 *
	 */
	public function moduleExists() {
		return TRUE;
	}

	/**
	 *
	 */
	public function logBox() {
		$logout = $this->url->getDirectory() . Module::PAGE_LOGOUT;

		return <<<HTML
<ul>
<li><a href="{$logout}">Logout</a></li>
</ul>
HTML;
	}

	/**
	 *
	 */
	public function menu() {
		$overview = $this->url->getDirectory() . Module::PAGE_OVERVIEW;
		$settings = $this->url->getDirectory() . Module::PAGE_SETTINGS;

		return <<<HTML
<ul>
<li><a href="{$overview}">Overview</a></li>
<li><a href="{$settings}">Settings</a></li>
</ul>
HTML;
	}
}

?>
