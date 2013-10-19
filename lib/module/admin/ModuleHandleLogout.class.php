<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleLogout extends ModuleHandleAbstract {
	/**
	 *
	 */
	public function content() {
		$this->user->logout();
		throw new \Exception($this->url->getURLBase() . Module::PAGE_LOGIN, 301);
	}

	/**
	 *
	 */
	public function logBox() {
		$this->content();
	}

	/**
	 *
	 */
	public function menu() {
		$this->content();
	}
}

?>
