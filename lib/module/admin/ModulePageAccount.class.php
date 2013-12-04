<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageAccount extends ModulePageAbstract {
	public function run() {
		// Check session
		if(!$this->session->isSignedIn()) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->result = $this->accountPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->accountPost() : $this->accountGet());
	}

	/**
	 *
	 */
	private function accountGet() {
		$this->pdbc->query('SELECT `username`, `email`
		                    FROM `user`
		                    WHERE `id` = "' . $this->pdbc->quote($this->session->getUserID()) . '"');

		return $this->pdbc->fetch() + array(
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function accountPost() {
		$fields = $this->accountGet();

		// Check fields
		if(!isset($_POST['password'], $_POST['email'])) {
			$fields['message'] = '<p class="msg-warning">Require password and email.</p>';
			return $fields;
		}

		$fields['email'] = $_POST['email'];

		// Update
		$this->pdbc->query('UPDATE `user`
		                    SET ' . ($_POST['password'] != '' ? '`password` = "' . $this->pdbc->quote($_POST['password']) . '",' : '') . '
		                        `email` = "' . $this->pdbc->quote($fields['email']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($this->session->getUserID()) . '"');

		if($this->pdbc->rowCount()) {
			$fields['message'] = '<p class="msg-succes">Your changes have been saved successfully</p>';
		}

		return $fields;
	}

	/**
	 *
	 */
	private function accountPage($fields) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Username', array(
			'type' => 'text',
			'id' => 'form-username',
			'name' => 'username',
			'value' => $fields['username'],
			'placeholder' => 'Username',
			'disabled' => 'disabled'
		));

		$form->addInput('Password', array(
			'type' => 'password',
			'id' => 'form-password',
			'name' => 'password',
			'placeholder' => 'Password'
		));

		$form->addInput('Email', array(
			'type' => 'email',
			'id' => 'form-email',
			'name' => 'email',
			'placeholder' => 'Email',
			'value' => $fields['email']
		));

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-account">Account</h2>' . $fields['message'] . $form->__toString();
	}
}

?>
