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
				throw new \lib\core\StatusCodeException($this->url->buildQuery(array('module' => 'theme')), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			break;
		}
	}

	/**
	 *
	 */
	private function overviewGet() {
		$this->pdbc->query('SELECT `id`,`name`
		                    FROM `module_theme`
		                    ORDER BY `name` ASC');

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
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->buildQuery(array('module' => 'theme', 'action' => self::ACTION_EDIT, 'id' => $field['id']), TRUE) . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->buildQuery(array('module' => 'theme', 'action' => self::ACTION_REMOVE, 'id' => $field['id']), TRUE) . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-theme">Theme</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->buildQuery(array('module' => 'theme', 'action' => self::ACTION_NEW), TRUE) . '">New theme</a></p>';
	}

	/**
	 *
	 */
	private function newGet() {
		return array(
			'name' => '',
			'error' => ''
		);
	}

	/**
	 *
	 */
	private function newPost() {
		$field = $this->newGet();

		// Check fields
		if(!isset($_POST['name'])) {
			$field['error'] = '<p class="msg-warning">Require name.</p>';
			return $field;
		}

		$field['name'] = $_POST['name'];

		// Update
		try {
			$this->pdbc->query('INSERT INTO `module_theme` (`name`) VALUES ("' . $this->pdbc->quote($field['name']) . '")');
		} catch(\lib\pdbc\PDBCException $e) {
			$field['error'] = '<p class="msg-error">This theme already exists. Please try again.</p>';
			return $field;
		}

		throw new \lib\core\StatusCodeException($this->url->buildQuery(array('module' => 'theme')), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
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

		$form->addContent('<a href="' . $this->url->buildQuery(array('module' => 'theme'), TRUE) . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">New theme</h2>' . $field['error'] . $form->__toString();
	}

	/**
	 *
	 */
	private function editGet($id) {
		$this->pdbc->query('SELECT `name`
		                    FROM `module_theme`
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"');

		return $this->pdbc->fetch() + array(
			'error' => ''
		);
	}

	/**
	 *
	 */
	private function editPost($id) {
		$field = $this->editGet($id);

		// Check fields
		if(!isset($_POST['name'])) {
			$field['error'] = '<p class="msg-warning">Require name.</p>';
			return $field;
		}

		// Check changes
		if($field['name'] === $_POST['name']) {
			return $field;
		}

		$field['name'] = $_POST['name'];

		// Update
		try {
			$this->pdbc->query('UPDATE `module_theme` SET `name` = "'. $this->pdbc->quote($field['name']) .'" WHERE `id` = "'. $this->pdbc->quote($id) .'"');
		} catch(\lib\pdbc\PDBCException $e) {
			$field['error'] = '<p class="msg-error">This theme already exists. Please try again.</p>';
			return $field;
		}

		$field['error'] = '<p class="msg-succes">Your changes have been saved successfully.</p>';
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

		$form->addContent('<a href="' . $this->url->buildQuery(array('module' => 'theme'), TRUE) . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">Edit theme</h2>' . $field['error'] . $form->__toString();
	}

	/**
	 *
	 */
	private function removeGet($id) {
		return array(
			'error' => ''
		);
	}

	/**
	 *
	 */
	private function removePost($id) {
		try {
			$this->pdbc->query('DELETE FROM `module_theme` WHERE `id` = "' . $this->pdbc->quote($id) .'"');
		} catch(\lib\pdbc\PDBCException $e) {
			return array(
				'error' => '<p class="msg-error">Can\'t remove a theme that is used. Please try again after removing the block, javascript, stylesheet & template that use this theme.</p>'
			);
		}

		throw new \lib\core\StatusCodeException($this->url->buildQuery(array('module' => 'theme')), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function removePage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<p>Are you sure you want to remove this theme? This action can\'t be undone!</p>');

		$form->addContent('<a href="' . $this->url->buildQuery(array('module' => 'theme'), TRUE) . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">Remove theme</h2>' . $field['error'] . $form->__toString();
	}
}

?>
