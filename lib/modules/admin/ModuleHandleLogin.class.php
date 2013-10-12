<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleLogin extends ModuleHandleAbstract {
	/**
	 *
	 */
	public function content() {
		$message = '';

		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($this->user->login($this->pdbc, $_POST['username'], $_POST['password'])) {
				throw new \Exception($this->url->getURLBase() . Module::PAGE_OVERVIEW, 301);
			}

			$message = <<<HTML
<p class="error">Invalid username or password.</p>
HTML;
		}

		return $message . <<<HTML
<form method="post" action="">
	<label for="username">Username:</label><input type="text" id="username" name="username" />
	<label for="password">Password:</label><input type="password" id="password" name="password" />
	<input type='submit' value='login' />
</form>
HTML;
	}

	/**
	 *
	 */
	public function logBox() {
		return <<<HTML
HTML;
	}

	/**
	 *
	 */
	public function menu() {
		return <<<HTML
HTML;
	}
}

?>
