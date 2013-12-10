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
		if(!isset($_GET['action'])) {
			$this->result = $this->overviewPage($this->overviewGet());
			return;
		}

		switch($_GET['action']) {
			case self::ACTION_NEW:
				$this->result = $this->newPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->newPost() : $this->newGet());
			break;

			case self::ACTION_EDIT:
				if(isset($_GET['id'])) {
					$this->result = $this->editPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->editPost($_GET['id']) : $this->editGet($_GET['id']));
				}
			break;

			case self::ACTION_REMOVE:
				if(isset($_GET['id'])) {
					$this->result = $this->removePage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->removePost($_GET['id']) : $this->removeGet($_GET['id']));
				}
			break;

			default:
				throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=theme', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			break;
		}
	}

	/**
	 *
	 */
	private function overviewGet() {
		$this->pdbc->query('SELECT `id`,`name`
		                    FROM `module_theme`
		                    ORDER BY `id` ASC');

		return $this->pdbc->fetchAll();
	}

	/**
	 *
	 */
	private function overviewPage($fieldRow) {
		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Edit','Remove'));

		foreach($fieldRow as $number => $field) {
			$table->openRow();
			$table->addColumn(++$number);
			$table->addColumn($field['name']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?module=theme&amp;action=' . self::ACTION_EDIT . '&amp;id=' . $field['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?module=theme&amp;action=' . self::ACTION_REMOVE . '&amp;id=' . $field['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-theme">Theme</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?module=theme&amp;action=' . self::ACTION_NEW . '">New theme</a></p>';
	}

	/**
	 *
	 */
	private function newGet() {
		return array(
			'name' => '',
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function newPost() {
		$field = $this->newGet();

		// Check fields
		if(!isset($_POST['name'])) {
			$field['message'] = '<p class="msg-warning">Require name.</p>';
			return $field;
		}

		$field['name'] = $_POST['name'];

		// Insert
		$this->pdbc->query('INSERT IGNORE INTO `module_theme` (`name`)
		                    VALUES ("' . $this->pdbc->quote($field['name']) . '")');

		if(!$this->pdbc->rowCount()) {
			$field['message'] = '<p class="msg-error">This theme already exists. Please try again.</p>';
			return $field;
		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=theme', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function newPage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?module=theme"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">New theme</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function editGet($id) {
		$this->pdbc->query('SELECT `name`
		                    FROM `module_theme`
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"');

		return $this->pdbc->fetch() + array(
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function editPost($id) {
		$field = $this->editGet($id);

		// Check fields
		if(!isset($_POST['name'])) {
			$field['message'] = '<p class="msg-warning">Require name.</p>';
			return $field;
		}

		// Check changes
		if($field['name'] === $_POST['name']) {
			return $field;
		}

		$field['name'] = $_POST['name'];

		// Update
		$this->pdbc->query('UPDATE IGNORE `module_theme`
		                    SET `name` = "'. $this->pdbc->quote($field['name']) .'"
		                    WHERE `id` = "'. $this->pdbc->quote($id) .'"');

		$field['message'] = $this->pdbc->rowCount() ? '<p class="msg-succes">Your changes have been saved successfully.</p>' : '<p class="msg-error">This theme already exists. Please try again.</p>';

		return $field;
	}

	/**
	 *
	 */
	private function editPage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?module=theme' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">Edit theme</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function removeGet($id) {
		return array(
			'message' => '<p>Are you sure you want to remove this theme? This action can\'t be undone!</p>'
		);
	}

	/**
	 *
	 */
	private function removePost($id) {
		$this->pdbc->query('DELETE FROM `module_theme` WHERE `id` = "' . $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=theme', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function removePage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<a href="' . $this->url->getPath() . '?module=theme' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">Remove theme</h2>' . $field['message'] . $form->__toString();
	}
}

?>
