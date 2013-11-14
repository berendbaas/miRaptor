<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageAccount extends ModulePageAbstract {
	public function content() {
		return $this->contentView($_SERVER['REQUEST_METHOD'] == 'POST' ? $this->contentModel() : '');
	}

	private function contentModel() {
		if(!isset($_POST['password'], $_POST['email'])) {
			return '<p class="msg-warning">Require password and email.</p>';
		}

		$this->pdbc->query('UPDATE `user`
		                    SET ' . ($password != '' ? '`password` = "' . $this->pdbc->quote($_POST['password']) . '",' : '') . '
		                        `email` = "' . $this->pdbc->quote($_POST['email']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		return !$this->pdbc->rowCount() ? '' : '<p class="msg-succes">Your changes have been saved successfully</p>';
	}

	private function contentView($message = '') {
		$this->pdbc->query('SELECT `username`, `email`
		                    FROM `user`
		                    WHERE `id` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		$user = $this->pdbc->fetch();

		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Username', array(
			'type' => 'text',
			'id' => 'form-username',
			'name' => 'username',
			'value' => $user['username'],
			'disabled' => 'disabled'
		));

		$form->addInput('Password', array(
			'type' => 'password',
			'id' => 'form-password',
			'name' => 'password',
			'placeholder' => 'password'
		));

		$form->addInput('Email', array(
			'type' => 'email',
			'id' => 'form-email',
			'name' => 'email',
			'value' => $user['email']
		));

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-account">Account</h2>' . $message . $form->__toString();
	}

	public function logBox() {
		$list = new \lib\html\HTMLList();

		$list->addItem('<a class="icon sign-out" href="' . $this->url->getDirectory() . Module::PAGE_SIGN_OUT . '">Sign Out</a>');

		return $list->__toString();
	}

	public function menu() {
		$list = new \lib\html\HTMLList();

		$list->addItem('<a class="icon icon-dashboard" href="' . $this->url->getDirectory() . Module::PAGE_DASHBOARD . '">Dashboard</a>');
		$list->addItem('<a class="icon icon-account" href="' . $this->url->getDirectory() . Module::PAGE_ACCOUNT . '">Account</a>');

		return '<h2 class="icon icon-menu">Menu</h2>' . $list->__toString();
	}
}

?>
