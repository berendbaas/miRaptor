<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageSignIn extends ModulePageAbstract {
	public function content() {
		return $this->contentView(isset($_POST['username'], $_POST['password']) ? $this->contentModel($_POST['username'], $_POST['password']) : '');
	}

	/**
	 *
	 */
	public function contentModel($username, $password) {
		if($this->user->login($this->pdbc, $username, $password)) {
			throw new \lib\core\StatusCodeException($this->url->getURLDirectory() . Module::PAGE_DASHBOARD, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		return '<p class="error">Invalid username or password. Please try again.</p>';
	}

	/**
	 *
	 */
	public function contentView($message = '') {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Username', array(
			'type' => 'text',
			'id' => 'form-username',
			'name' => 'username',
			'placeholder' => 'Username'
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

		return '<h2 class="icon icon-sign-in">Sign In</h2>' . $message . $form->__toString();
	}

	public function logBox() {
		return '';
	}

	public function menu() {
		return '';
	}
}

?>
