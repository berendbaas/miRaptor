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
		// Check user
		if(!$this->user->isSignedIn()) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->result = $this->accountPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->accountPost() : $this->accountGet());
	}

	/**
	 *
	 */
	private function accountGet() {
		return array(
			'username' => $this->user->getUsername(),
			'email' => $this->user->getEmail(),
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function accountPost() {
		$oldField = $this->accountGet();

		// Check password
		if(!isset($_POST['password'], $_POST['email'])) {
			$oldField['message'] = '<p class="msg-warning">Require password and email.</p>';
			return $oldField;
		}
		
		$field = array(
			'username' => $oldField['username'],
			'email' => $_POST['email'],
			'message' => ''
		);

		// Check password
		if($_POST['password'] !== '') {
			if(!$this->user->changePassword($_POST['password'])) {
				$field['message'] = '<p class="msg-succes">Bad password.</p>';
				return $field;
			}

			$field['message'] = '<p class="msg-succes">Your changes have been saved successfully.</p>';
		}

		// Check data
		if($field['email'] !== $oldField['email']) {
			$this->pdbc->query('UPDATE `user`
			                    SET `email` = "' . $this->pdbc->quote($field['email']) . '"
			                    WHERE `id` = "' . $this->pdbc->quote($this->user->getID()) . '"');

			$field['message'] = '<p class="msg-succes">Your changes have been saved successfully.</p>';
		}

		return $field;
	}

	/**
	 *
	 */
	private function accountPage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Username', array(
			'type' => 'text',
			'id' => 'form-username',
			'name' => 'username',
			'value' => $field['username'],
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
			'value' => $field['email']
		));

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-account">Account</h2>' . $field['message'] . $form->__toString();
	}
}

?>
