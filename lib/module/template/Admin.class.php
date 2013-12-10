<?php
namespace lib\module\template;

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
				throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=template', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			break;
		}
	}

	/**
	 *
	 */
	private function overviewGet() {
		$this->pdbc->query('SELECT `module_template`.`id`, `module_template`.`name`, `theme`.`name` AS `theme`
		                    FROM `module_template`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `module_template`.`id_theme` = `theme`.`id`
		                    ORDER BY `id` ASC');

		return $this->pdbc->fetchAll();
	}

	/**
	 *
	 */
	private function overviewPage($fieldRow) {
		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Theme','Edit','Remove'));

		foreach($fieldRow as $number => $field) {
			$table->openRow();
			$table->addColumn(++$number);
			$table->addColumn($field['name']);
			$table->addColumn($field['theme']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?module=template&amp;action=' . self::ACTION_EDIT . '&amp;id=' . $field['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?module=template&amp;action=' . self::ACTION_REMOVE . '&amp;id=' . $field['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-template">Template</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?module=template&amp;action=' . self::ACTION_NEW . '">New template</a></p>';
	}

	/**
	 *
	 */
	private function newGet() {
		return array(
			'name' => '',
			'theme' => '',
			'template' => '',
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function newPost() {
		$field = $this->newGet();

		// Check fields
		if(!isset($_POST['theme'], $_POST['name'], $_POST['template'])) {
			$field['message'] = '<p class="msg-warning">Require theme, name & template.</p>';
			return $field;
		}

		$field['theme'] = $_POST['theme'];
		$field['name'] = $_POST['name'];
		$field['template'] = $_POST['template'];

		// Insert
		$this->pdbc->query('INSERT IGNORE INTO `module_template` (`id_theme`, `name`, `content`)
		                    VALUES ("' . $this->pdbc->quote($field['theme']) . '",
		                            "' . $this->pdbc->quote($field['name']) . '",
		                            "' . $this->pdbc->quote($field['template']) . '")');

		if(!$this->pdbc->rowCount()) {
			$field['message'] = '<p class="msg-error">This template already exists. Please try again.</p>';
			return $field;
		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=template', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function newPage($field) {
		// Get themes
		$this->pdbc->query('SELECT `id`,`name` FROM `module_theme`');

		$themes = array();

		while($theme = $this->pdbc->fetch()) {
			if($theme['id'] !== $field['theme']) {
				$themes[$theme['name']] = array(
					'value' => $theme['id']
				);
			} else {
				$themes[$theme['name']] = array(
					'value' => $theme['id'],
					'selected' => 'selected'
				);
			}
		}

		// Form
		$form = new \lib\html\HTMLFormStacked();

		$form->addSelect('Theme', $themes, array(
			'id' => 'form-theme',
			'name' => 'theme'
		));

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addTextarea('Template', $field['template'], array(
			'id' => 'form-template',
			'name' => 'template',
			'placeholder' => 'Template'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?module=template' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-template">Edit template</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function editGet($id) {
		$this->pdbc->query('SELECT `id_theme` AS `theme`, `name`, `content` AS `template`
		                    FROM `module_template`
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
		if(!isset($_POST['theme'], $_POST['name'], $_POST['template'])) {
			$field['message'] = '<p class="msg-warning">Require theme, name & template.</p>';
			return $field;
		}

		// Check changes
		if($field['theme'] === $_POST['theme'] && $field['name'] === $_POST['name'] && $field['template'] === $_POST['template']) {
			return $field;
		}

		$field['theme'] = $_POST['theme'];
		$field['name'] = $_POST['name'];
		$field['template'] = $_POST['template'];

		// Update
		$this->pdbc->query('UPDATE IGNORE `module_template`
		                    SET `id_theme` = "'. $this->pdbc->quote($field['theme']) .'",
		                        `name` = "'. $this->pdbc->quote($field['name']) .'",
		                        `content` = "'. $this->pdbc->quote($field['template']) .'"
		                    WHERE `id` = "'. $this->pdbc->quote($id) . '"');

		$field['message'] = $this->pdbc->rowCount() ? '<p class="msg-succes">Your changes have been saved successfully.</p>' : '<p class="msg-error">This theme already exists. Please try again.</p>';

		return $field;
	}

	/**
	 *
	 */
	private function editPage($field) {
		// Get themes
		$this->pdbc->query('SELECT `id`,`name` FROM `module_theme`');

		$themes = array();

		while($theme = $this->pdbc->fetch()) {
			if($theme['id'] !== $field['theme']) {
				$themes[$theme['name']] = array(
					'value' => $theme['id']
				);
			} else {
				$themes[$theme['name']] = array(
					'value' => $theme['id'],
					'selected' => 'selected'
				);
			}
		}

		// Form
		$form = new \lib\html\HTMLFormStacked();

		$form->addSelect('Theme', $themes, array(
			'id' => 'form-theme',
			'name' => 'theme'
		));

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addTextarea('Template', $field['template'], array(
			'id' => 'form-template',
			'name' => 'template',
			'placeholder' => 'Template'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?module=template' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-template">Edit template</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function removeGet($id) {
		return array(
			'message' => '<p>Are you sure you want to remove this template? This action can\'t be undone!</p>'
		);
	}

	/**
	 *
	 */
	private function removePost($id) {
		$this->pdbc->query('DELETE FROM `module_template` WHERE `id` = "' . $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=template', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function removePage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<a href="' . $this->url->getPath() . '?module=template' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-template">Remove template</h2>' . $field['message'] . $form->__toString();
	}
}

?>
