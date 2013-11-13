<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageSignOut extends ModulePageAbstract {
	public function content() {
		$this->model();
	}

	public function logBox() {
		$this->model();
	}
	
	public function menu() {
		$this->model();
	}

	/**
	 *
	 */
	private function model() {
		$this->user->logout();
		throw new \lib\core\StatusCodeException($this->url->getURLDirectory() . Module::PAGE_SIGN_IN, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}
}

?>
