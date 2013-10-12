<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleSite extends ModuleHandleAbstract {
	/**
	 *
	 */
	public function content() {
		return 'TODO site';
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
