<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageSignOut extends ModulePageAbstract {
	public function run() {
		// Check user
		if($this->user->isSignedIn()) {
			$this->user->signout();
		}

		throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}
}

?>
