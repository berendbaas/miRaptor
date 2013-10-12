<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleSettings extends ModuleHandleAbstract {
	/**
	 *
	 */
	public function content() {
		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'changepassword':
					return $this->handleChangePassword();
					break;
				
				case 'changeemail':
					return $this->handleChangeEmail();
					break;
			}
		}
		return $this->handleSettingsDefault();
	}


	private function handleSettingsDefault() {
		$result = <<<HTML
<tr>
	<td><a href="?action=changepassword"> Change Password</a></td>
	<td><a href="?action=changeemail"> Change E-mail adress</a></td>
</tr>
HTML;
		return $result;
	}

	private function handleChangePassword() {
		$message = '';

		if (isset($_POST['password'])) {
			$this->pdbc->query('UPDATE `user`
			                        SET `password` = "' . $this->pdbc->quote($_POST['password']) . '"
			                        WHERE `id` = "' . $this->pdbc->quote($this->user->getID()) . '"');
			if ($this->pdbc->rowCount() > 0) {
				throw new \Exception($this->url->getURLBase() . Module::PAGE_SETTINGS, 301);
			}
			else {
				$message .= <<<HTML
<p class="error">Can't change password.</p>
HTML;
			}
		}

		$cancel= $this->url->getDirectory() . Module::PAGE_SETTINGS;
		$result = <<<HTML
<form action="" method="POST">
	<label for="password"><input type="password" name="password">
	<input type="submit"><a href="{$cancel}">Back</a>
</form>
HTML;

	return $message . $result;
	}

	private function handleChangeEmail() {
		$message = '';

		if (isset($_POST['email'])) {
			$this->pdbc->query('UPDATE `user`
			                        SET `email` = "' . $this->pdbc->quote($_POST['email']) . '"
			                        WHERE `id` = "' . $this->pdbc->quote($this->user->getID()) . '"');
			if ($this->pdbc->rowCount() >0) {
				throw new \Exception($this->url->getURLBase() . Module::PAGE_SETTINGS, 301);
			}
			else {
				$message .= <<<HTML
<p class="error">Can't change email</p>
HTML;
			}
		}
		$cancel = $this->url->getDirectory() . Module::PAGE_SETTINGS;
		$form = <<<HTML
<form action="" method="POST">
	<label for="email"><input type="text" name="email">
	<input type="submit"><a href="{$cancel}">Back</a>
</form>
HTML;

	return $message . $form;
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
