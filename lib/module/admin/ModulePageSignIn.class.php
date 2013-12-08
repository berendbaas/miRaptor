<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageSignIn extends ModulePageAbstract {
	public function run() {
		// Check session
		if($this->session->isSignedIn()) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->result = $this->signInPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->signInPost() : $this->signInGet());
	}

	/**
	 *
	 */
	private function signInGet() {
		return array(
			'username' => '',
			'password' => '',
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function signInPost() {
		$fields = $this->signInGet();

		// Check fields
		if(!isset($_POST['username'], $_POST['password'])) {
			$fields['message'] = '<p class="msg-warning">Require username and password.</p>';
			return $fields;
		}

		$fields['username'] = $_POST['username'];

		// Check credentials
		if(!($this->session->signIn($fields['username'], $_POST['password']))) {
			$fields['message'] = '<p class="msg-error">Invalid username or password. Please try again.</p>';
			return $fields;
		}

		throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function signInPage($fields) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Username', array(
			'type' => 'text',
			'id' => 'form-username',
			'name' => 'username',
			'placeholder' => 'Username',
			'value' => $fields['username']
		));

		$form->addInput('Password', array(
			'type' => 'password',
			'id' => 'form-password',
			'name' => 'password',
			'placeholder' => 'Password'
		));

		$form->addButton('Sign In', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-sign-in">Sign In</h2>' . $fields['message'] . $form->__toString();
	}
}

?>
