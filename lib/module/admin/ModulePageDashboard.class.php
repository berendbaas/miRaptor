<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageDashboard extends ModulePageAbstract {
	const ACTION_SETTINGS = 'settings';
	const ACTION_STATUS = 'active';

	public function content() {
		if(isset($_GET['action'], $_GET['id'])) {
			return $this->handleAction($_GET['action'], intval($_GET['id']));
		}

		return $this->getDashboard();
	}

	/**
	 *
	 */
	private function handleAction($action, $id) {
		if(!$this->hasAccess($id)) {
			// You do not own this website.
			throw new \lib\core\StatusCodeException($this->url->getURLPath(), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		switch($action) {
			case self::ACTION_SETTINGS:
				return $this->getSettings($id, ($_SERVER['REQUEST_METHOD'] == 'POST' ? $this->postSettings($id) : ''));
			break;

			case self::ACTION_STATUS:
				return $this->getStatus($id, ($_SERVER['REQUEST_METHOD'] == 'POST' ? $this->postStatus($id) : ''));
			break;

			default:
				// Action not supported.
				throw new \lib\core\StatusCodeException($this->url->getURLPath(), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			break;
		}
	}

	/**
	 *
	 */
	private function postSettings($id) {
		if(!isset($_POST['name'], $_POST['domain'])) {
			return '<p class="msg-warning">Require name and domain.</p>';
		}

		$this->pdbc->query('UPDATE `website`
		                    SET `name` =  "' . $this->pdbc->quote($_POST['name']) . '",
		                        `domain` =  "' . $this->pdbc->quote($_POST['domain']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		return !$this->pdbc->rowCount() ? '' : '<p class="msg-succes">Your changes have been saved successfully</p>';
	}

	/**
	 *
	 */
	private function getSettings($id, $message = '') {
		$this->pdbc->query('SELECT `name`, `domain`
		                    FROM `website`
		                    WHERE `id` = ' . $this->pdbc->quote($id) . '
		                    AND`uid` = ' . $this->pdbc->quote($this->user->getID()));

		$website = $this->pdbc->fetch();

		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'value' => $website['name']
		));

		$form->addInput('Domain', array(
			'type' => 'text',
			'id' => 'form-domain',
			'name' => 'domain',
			'value' => $website['domain']
		));

		$form->addContent('<a href="' . $this->url->getPath() . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-settings">Website settings</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function postStatus($id) {
		$this->pdbc->query('UPDATE `website`
		                    SET `active` =  "' . (isset($_POST['status']) ? 1 : 0) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		return !$this->pdbc->rowCount() ? '' : '<p class="msg-succes">Your changes have been saved successfully</p>';
	}

	/**
	 *
	 */
	private function getStatus($id, $message = '') {
		$this->pdbc->query('SELECT `active`
		                    FROM `website`
		                    WHERE `id` = ' . $this->pdbc->quote($id) . '
		                    AND`uid` = ' . $this->pdbc->quote($this->user->getID()));

		$website = $this->pdbc->fetch();

		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Active', array(
			'type' => 'checkbox',
			'id' => 'form-active-on',
			'name' => 'active',
			'value' => '1'
		) + ($website['active'] ? array('checked' => 'checked') : array()));

		$form->addContent('<a href="' . $this->url->getPath() . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-settings">Website status</h2>' . $form->__toString();
	}

	/**
	 *
	 */
	private function getDashboard() {
		$this->pdbc->query('SELECT `id`,`name`,`active`
		                    FROM `website`
		                    WHERE `uid` = ' . $this->pdbc->quote($this->user->getID()));

		$websites = $this->pdbc->fetchAll();

		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Website','Settings','Status'));

		foreach($websites as $website) {
			$table->openRow();
			$table->addColumn($website['id']);
			$table->addColumn('<a href="' . $this->url->getDirectory() . Module::PAGE_SITE . '?id=' . $website['id'] . '">' . $website['name'] . '</a>');
			$table->addColumn('<a class="icon icon-settings" href="' . $this->url->getPath() . '?action=' . self::ACTION_SETTINGS . '&amp;id=' . $website['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-active-' . $website['active'] . '" href="' . $this->url->getPath() . '?action=' . self::ACTION_STATUS . '&amp;id=' . $website['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-dashboard">Dashboard</h2>' . $table->__toString();
	}

	public function logBox() {
		$list = new \lib\html\HTMLList();

		$list->addItem('<a class="icon icon-sign-out" href="' . $this->url->getDirectory() . Module::PAGE_SIGN_OUT . '">Sign Out</a>');

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
