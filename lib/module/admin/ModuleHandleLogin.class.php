<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleLogin extends ModuleHandleAbstract {
	public function content() {
		$message = '';

		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($this->user->login($this->pdbc, $_POST['username'], $_POST['password'])) {
				throw new \Exception($this->url->getURLDirectory() . Module::PAGE_OVERVIEW, 301);
			}

			$message = <<<HTML
	<p class="error">Invalid username or password. Please try again.</p>
HTML;
		}

		return <<<HTML
<h2>Login</h2>
{$message}
<form method="post" action="">
	<div><label for="username">Username</label><input type="text" name="username" placeholder="Username" /></div>
	<div><label for="password">Password</label><input type="password" name="password" placeholder="Password" /></div>
	<div><button type="submit">Login</button></div>
</form>
HTML;
	}

	public function logBox() {
		return <<<HTML
HTML;
	}

	public function menu() {
		return <<<HTML
HTML;
	}
}

?>
