<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleSettings extends ModuleHandleAbstract {
	const EDIT = 'edit';
	const EDIT_PASSWORD = 'password';
	const EDIT_MAIL = 'mail';

	/**
	 *
	 */
	public function content() {
		if (isset($_GET[self::EDIT])) {
			switch ($_GET[self::EDIT]) {
				case self::EDIT_PASSWORD:
					return $this->handleEditPassword();
				break;
				
				case self::EDIT_MAIL:
					return $this->handleEditMail();
				break;
			}
		}

		return $this->handleEditDefault();
	}

	private function handleEditPassword() {
		$message = '';

		if(isset($_POST['password'])) {
			$message = $this->handleEditPasswordPost();
		}

		return $this->handleEditPasswordGet($message);
	}

	private function handleEditPasswordPost() {
		$this->pdbc->query('UPDATE `user`
		                    SET `password` = "' . $this->pdbc->quote($_POST['password']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		if($this->pdbc->rowCount() > 0) {
			throw new \Exception($this->url->getURLPath(), 301);
		}
		
		return <<<HTML
<p class="error">Can't change password.</p>
HTML;
	}

	private function handleEditPasswordGet($message = '') {
		$cancel= $this->url->getDirectory() . Module::PAGE_SETTINGS;

		return <<<HTML
<h2>Edit password</h2>
{$message}
<form method="POST" action="">
	<div><label for="password">Password</label><input type="password" name="password" placeholder="Password" /></div>
	<div><a href="{$cancel}"><button type="button">Back</button></a><button type="submit">Submit</button></div>
</form>
HTML;
	}

	private function handleEditMail() {
		$message = '';

		if(isset($_POST['email'])) {
			$message = $this->handleEditMailPost();
		}

		return $this->handleEditMailGet($message);
	}

	private function handleEditMailPost() {
		$this->pdbc->query('UPDATE `user`
		                    SET `email` = "' . $this->pdbc->quote($_POST['email']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		if($this->pdbc->rowCount() >0) {
			throw new \Exception($this->url->getURLPath(), 301);
		}

		return <<<HTML
<p class="error">Can't change email</p>
HTML;
	}

	private function handleEditMailGet($message = '') {
		$cancel = $this->url->getDirectory() . Module::PAGE_SETTINGS;

		return <<<HTML
<h2>Edit email address</h2>
{$message}
<form action="" method="POST">
	<div><label for="email">Email</label><input type="text" name="email" placeholder="Email address" /></div>
	<div><a href="{$cancel}"><button type="button">Cancel</button></a><button type="submit">Submit</button></div>
</form>
HTML;
	}

	private function handleEditDefault() {
		$password = $this->url->getDirectory() . Module::PAGE_SETTINGS . '?' . self::EDIT . '=' . self::EDIT_PASSWORD;
		$mail = $this->url->getDirectory() . Module::PAGE_SETTINGS . '?' . self::EDIT . '=' . self::EDIT_MAIL;

		$result = <<<HTML
<h2>Settings</h2>
<p><a href="{$password}">Edit password</a><br />
<a href="{$mail}">Edit email address</a></p>
HTML;
		return $result;
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
<h2>Menu</h2>
<ul>
	<li><a href="{$overview}">Overview</a></li>
	<li><a href="{$settings}">Settings</a></li>
</ul>
HTML;
	}
}

?>
