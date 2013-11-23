<?php
namespace lib\module\theme;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin extends \lib\core\AbstractAdmin {
	const ACTION_NEW = 'new';
	const ACTION_EDIT = 'edit';
	const ACTION_REMOVE = 'remove';

	public function run() {
		$this->result = isset($_GET['action'], $_GET['tid']) ? $this->handleAction($_GET['action'], $_GET['tid']) : $this->getOverview();
	}

	/**
	 *
	 */
	private function handleAction($action, $id) {
		switch($action) {
			case self::ACTION_NEW:
				return $this->getNew($id, ($_SERVER['REQUEST_METHOD'] == 'POST' ? $this->postNew($id) : ''));
			break;
			case self::ACTION_EDIT:
				return $this->getEdit($id, ($_SERVER['REQUEST_METHOD'] == 'POST' ? $this->postEdit($id) : ''));
			break;
			case self::ACTION_REMOVE:
				return $this->getRemove($id, ($_SERVER['REQUEST_METHOD'] == 'POST' ? $this->postRemove($id) : ''));
			break;
			default:

			break;
		}
	}

	/**
	 *
	 */
	private function postNew($id) {
		$this->pdbc->query('INSERT INTO `module_theme` (`name`)
		                    VALUES ("' . $this->pdbc->quote($_POST['name']) . '")');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=theme', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getNew($id, $message = '') {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=theme' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">New theme</h2>' . $message . $form->__toString();

	}

	/**
	 *
	 */
	private function postEdit($id) {
		$this->pdbc->query('UPDATE `module_theme`
		                    SET `name` = "'. $this->pdbc->quote($_POST['name']) .'"
		                    WHERE `id` = "'. $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=theme', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getEdit($id, $message = '') {
		$this->pdbc->query('SELECT `name`
		                    FROM `module_theme`
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"');

		$theme = $this->pdbc->fetch();

		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $theme['name']
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=theme' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">Edit theme</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function postRemove($id) {
		$this->pdbc->query('DELETE FROM `module_theme` WHERE `id` = "' . $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=theme', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getRemove($id, $message = '') {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<label>Are you sure you want to remove this theme? This action can\'t be undone!</label>');

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=theme' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">Remove theme</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function getOverview() {
		$this->pdbc->query('SELECT `id`,`name`
		                    FROM `module_theme`
		                    ORDER BY `id` ASC');

		$themes = $this->pdbc->fetchAll();

		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Edit','Remove'));

		foreach($themes as $test => $theme) {
			$table->openRow();
			$table->addColumn($theme['id']);
			$table->addColumn($theme['name']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=theme&amp;action=' . self::ACTION_EDIT . '&amp;tid=' . $theme['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=theme&amp;action=' . self::ACTION_REMOVE . '&amp;tid=' . $theme['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-theme">Theme</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=theme&amp;action=' . self::ACTION_NEW . '&amp;tid=0">New theme</a></p>';
	}
}

?>
