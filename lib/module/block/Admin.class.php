<?php
namespace lib\module\block;

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
				throw new \lib\core\StatusCodeException($this->url->buildQuery(array('module' => 'block')), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			break;
		}
	}

	/**
	 *
	 */
	private function overviewGet() {
		$this->pdbc->query('SELECT `block`.`id`, `block`.`name`, `theme`.`name` AS `theme`
		                    FROM `module_block` as `block`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `block`.`id_theme` = `theme`.`id`
		                    ORDER BY `theme`.`name` ASC, block.`name` ASC');

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
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->buildQuery(array('module' => 'block', 'action' => self::ACTION_EDIT, 'id' => $field['id']), TRUE) . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->buildQuery(array('module' => 'block', 'action' => self::ACTION_REMOVE, 'id' => $field['id']), TRUE) . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-block">Block</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->buildQuery(array('module' => 'block', 'action' => self::ACTION_NEW), TRUE) . '">New block</a></p>';
	}

	/**
	 *
	 */
	private function newGet() {
		return array(
			'name' => '',
			'theme' => '',
			'block' => '',
			'error' => ''
		);
	}

	/**
	 *
	 */
	private function newPost() {
		$field = $this->newGet();

		// Check fields
		if(!isset($_POST['theme'], $_POST['name'], $_POST['block'])) {
			$field['error'] = '<p class="msg-warning">Require theme, name & block.</p>';
			return $field;
		}

		$field['theme'] = $_POST['theme'];
		$field['name'] = $_POST['name'];
		$field['block'] = $_POST['block'];

		// Insert
		try {
			$this->pdbc->query('INSERT INTO `module_block` (`id_theme`, `name`, `content`)
			                    VALUES ("' . $this->pdbc->quote($field['theme']) . '",
			                            "' . $this->pdbc->quote($field['name']) . '",
			                            "' . $this->pdbc->quote($field['block']) . '")');
		} catch(\lib\pdbc\PDBCException $e) {
			$field['error'] = '<p class="msg-error">This block already exists. Please try again.</p>';
			return $field;
		}

		throw new \lib\core\StatusCodeException($this->url->buildQuery(array('module' => 'block')), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function newPage($field) {
		// Form
		$form = new \lib\html\HTMLFormStacked();

		// Get themes
		$this->pdbc->query('SELECT `id`,`name` FROM `module_theme` ORDER BY `name`');

		$form->openSelect('Theme', array(
			'id' => 'form-theme',
			'name' => 'theme'
		));

		while($theme = $this->pdbc->fetch()) {
			$attributes = array(
				'value' => $theme['id']
			);

			if($theme['id'] !== $field['theme']) {
				$attributes['selected'] = 'selected';
			}

			$form->addOption($theme['name'], $attributes);
		}

		$form->closeSelect();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addTextarea('Block', $field['block'], array(
			'id' => 'form-block',
			'name' => 'block',
			'placeholder' => 'Block'
		));

		$form->addContent('<a href="' . $this->url->buildQuery(array('module' => 'block'), TRUE) . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-block">Edit block</h2>' . $field['error'] . $form->__toString();
	}

	/**
	 *
	 */
	private function editGet($id) {
		$this->pdbc->query('SELECT `id_theme` AS `theme`, `name`, `content` AS `block`
		                    FROM `module_block`
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
		if(!isset($_POST['theme'], $_POST['name'], $_POST['block'])) {
			$field['error'] = '<p class="msg-warning">Require theme, name & block.</p>';
			return $field;
		}

		// Check changes
		if($field['theme'] === $_POST['theme'] && $field['name'] === $_POST['name'] && $field['block'] === $_POST['block']) {
			return $field;
		}

		$field['theme'] = $_POST['theme'];
		$field['name'] = $_POST['name'];
		$field['block'] = $_POST['block'];

		// Update
		try {
			$this->pdbc->query('UPDATE `module_block`
			                    SET `id_theme` = "'. $this->pdbc->quote($field['theme']) .'",
			                        `name` = "'. $this->pdbc->quote($field['name']) .'",
			                        `content` = "'. $this->pdbc->quote($field['block']) .'"
			                    WHERE `id` = "'. $this->pdbc->quote($id) . '"');
		} catch(\lib\pdbc\PDBCException $e) {
			$field['error'] = '<p class="msg-error">This block already exists. Please try again.</p>';
			return $field;
		}

		$field['error'] = '<p class="msg-succes">Your changes have been saved successfully.</p>';
		return $field;
	}

	/**
	 *
	 */
	private function editPage($field) {
		// Form
		$form = new \lib\html\HTMLFormStacked();

		// Get themes
		$this->pdbc->query('SELECT `id`,`name` FROM `module_theme` ORDER BY `name`');

		$form->openSelect('Theme', array(
			'id' => 'form-theme',
			'name' => 'theme'
		));

		while($theme = $this->pdbc->fetch()) {
			$attributes = array(
				'value' => $theme['id']
			);

			if($theme['id'] !== $field['theme']) {
				$attributes['selected'] = 'selected';
			}

			$form->addOption($theme['name'], $attributes);
		}

		$form->closeSelect();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addTextarea('Block', $field['block'], array(
			'id' => 'form-block',
			'name' => 'block',
			'placeholder' => 'Block'
		));

		$form->addContent('<a href="' . $this->url->buildQuery(array('module' => 'block'), TRUE) . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-block">Edit block</h2>' . $field['error'] . $form->__toString();
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
			$this->pdbc->query('DELETE FROM `module_block` WHERE `id` = "' . $this->pdbc->quote($id) .'"');
		} catch(\lib\pdbc\PDBCException $e) {
			return array(
				'error' => '<p class="msg-error">Can\'t remove block.</p>'
			);
		}

		throw new \lib\core\StatusCodeException($this->url->buildQuery(array('module' => 'block')), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function removePage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<p>Are you sure you want to remove this block This action can\'t be undone!</p>');

		$form->addContent('<a href="' . $this->url->buildQuery(array('module' => 'block'), TRUE) . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-block">Remove block</h2>' . $field['error'] . $form->__toString();
	}
}

?>
