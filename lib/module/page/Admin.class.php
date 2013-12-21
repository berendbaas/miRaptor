<?php
namespace lib\module\page;

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

	const DEPTH_MARK = '&mdash; ';

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
		$this->pdbc->query('SELECT `id`, `name`, `depth`, `uri` FROM `router` ORDER BY `uri` ASC');

		return $this->pdbc->fetchAll();
	}

	/**
	 *
	 */
	private function overviewPage($fieldRow) {
		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','URI','Edit','Remove'));

		foreach($fieldRow as $number => $field) {
			$table->openRow();
			$table->addColumn(++$number);
			$table->addColumn($this->markDepth($field['name'], $field['depth']));
			$table->addColumn($field['uri']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?module=page&amp;action=' . self::ACTION_EDIT . '&amp;id=' . $field['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?module=page&amp;action=' . self::ACTION_REMOVE . '&amp;id=' . $field['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-page">Page</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?module=page&amp;action=' . self::ACTION_NEW . '">New page</a></p>';
	}

	/**
	 *
	 */
	private function newGet() {
		return array(
			'parent' => '',
			'index' => '0',
			'name' => '',
			'content' => '',
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
		if(!isset($_POST['parent'], $_POST['index'], $_POST['name'], $_POST['content'], $_POST['template'])) {
			$field['message'] = '<p class="msg-warning">Require parent, index, name, content & template.</p>';
			return $field;
		}

		$field = array(
			'parent' => $_POST['parent'],
			'index' => $_POST['index'],
			'name' => $_POST['name'],
			'content' => $_POST['content'],
			'template' => $_POST['template']
		);

		// Begin transaction
		$this->pdbc->transactionBegin();

		// Insert router
		try {
			$this->pdbc->query('INSERT INTO `router` (`pid`, `index`, `name`)
			                    VALUES (NULLIF("' . $this->pdbc->quote($field['parent']) . '", 0),
			                                   "' . $this->pdbc->quote($field['index']) . '",
			                                   "' . $this->pdbc->quote($field['name']) . '")');
		} catch(\lib\pdbc\PDBCException $e) {
			$this->pdbc->transactionRollBack();
			$field['message'] = '<p class="msg-error">This page already exists. Please try again.</p>';
			return $field;
		}

		// Insert hierarchy
		$insertID = $this->pdbc->insertID();

		try {
			$this->updateRouter($insertID);
		} catch(\lib\pdbc\PDBCException $e) {
			$this->pdbc->transactionRollBack();
			$field['message'] = '<p class="msg-error">This URI already exists. Please try again.</p>';
			return $field;
		}

		// Insert page
		try {
			$this->pdbc->query('INSERT INTO `module_page` (`id_router`,`id_template`,`content`)
			                    SELECT "' . $insertID . '",
			                           `id`,
			                           "' . $this->pdbc->quote($field['content']) . '"
			                    FROM `module_template`
			                    WHERE `id` = "' . $this->pdbc->quote($field['template']) . '"');
		} catch(\lib\pdbc\PDBCException $e) {
			$this->pdbc->transactionRollBack();
			$field['message'] = '<p class="msg-error">Template doesn\'t exists. Please try again.</p>';
			return $field;
		}

		// Commit transaction
		$this->pdbc->transactionCommit();

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=page', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function newPage($field) {
		// Parents
		$this->pdbc->query('SELECT `id`, `name`, `depth` FROM `router` ORDER BY `uri` ASC');

		$parents = array('' => array('value' => 0));
		$number = 1;

		while($parent = $this->pdbc->fetch()) {
			$name = $number++ . '. ' . $this->markDepth($parent['name'], $parent['depth']);
			$value = array(
				'value' => $parent['id']
			);

			if($parent['id'] === $field['parent']) {
				$value['selected'] = 'selected';
			}

			$parents[$name] = $value;
		}

		// Templates
		$this->pdbc->query('SELECT `id`, `name` FROM `module_template` ORDER BY `id`');

		$templates = array();

		while($template = $this->pdbc->fetch()) {
			$value = ['value' => $template['id']];

			if($template['id'] === $field['template']) {
				$value['selected'] = 'selected';
			}

			$templates[$template['name']] = $value;
		}

		// Form
		$form = new \lib\html\HTMLFormStacked();

		// Page
		$form->openFieldset('Page');

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addTextarea('Content', $field['content'], array(
			'id' => 'form-content',
			'name' => 'content',
			'placeholder' => 'Content'
		));

		$form->closeFieldset();

		// Hierarchy
		$form->openFieldset('Hierarchy');

		$form->addSelect('Parent', $parents, array(
			'id' => 'form-parent',
			'name' => 'parent'
		));

		$form->addInput('Index', array(
			'type' => 'number',
			'id' => 'form-index',
			'name' => 'index',
			'placeholder' => 'Index',
			'value' => $field['index']
		));

		$form->closeFieldset();

		// Style
		$form->openFieldset('Style');

		$form->addSelect('Template', $templates, array(
			'id' => 'form-template',
			'name' => 'template'
		));

		$form->closeFieldset();

		$form->addContent('<a href="' . $this->url->getPath() . '?module=page' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-page">New page</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function editGet($id) {
		$this->pdbc->query('SELECT `router`.`pid` as `parent`,
		                           `router`.`index`,
		                           `router`.`name`,
					   `router`.`uri`,
		                           `module_page`.`content`,
		                           `module_page`.`id_template` as `template`
		                    FROM `router`
		                    LEFT JOIN `module_page`
		                    ON `router`.`id` = `module_page`.`id_router`
		                    WHERE `router`.`id` = "' . $this->pdbc->quote($id) . '"');

		return $this->pdbc->fetch() + array(
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function editPost($id) {
		$oldField = $this->editGet($id);

		// Check fields
		if(!isset($_POST['parent'], $_POST['index'], $_POST['name'], $_POST['content'], $_POST['template'])) {
			$oldField['message'] = '<p class="msg-warning">Require parent, index, name, content & template.</p>';
			return $oldField;
		}

		$field = array(
			'parent' => $_POST['parent'] == 0 ? NULL : $_POST['parent'],
			'index' => $_POST['index'],
			'name' => $_POST['name'],
			'uri' => $oldField['uri'],
			'content' => $_POST['content'],
			'template' => $_POST['template'],
			'message' => ''
		);

		// Check changes
		if($field['parent'] != $oldField['parent'] || $field['index'] != $oldField['index'] || $field['name'] != $oldField['name']) {
			// Begin transaction
			$this->pdbc->transactionBegin();

			// Update router
			try {
				$this->pdbc->query('UPDATE `router`
				                    SET `pid` = NULLIF("' . $this->pdbc->quote($field['parent']) . '", 0),
				                        `index` = "' . $this->pdbc->quote($field['index']) . '",
				                        `name` = "' . $this->pdbc->quote($field['name']) . '"
				                    WHERE `id` = "'. $this->pdbc->quote($id) . '"');
			} catch(\lib\pdbc\PDBCException $e) {
				$this->pdbc->transactionRollBack();
				$field['message'] = '<p class="msg-error">This page already exists. Please try again.</p>';
				return $field;
			}

			// Update hierarchy
			try {
				$this->updateRouter($id);
			} catch(\lib\pdbc\PDBCException $e) {
				$this->pdbc->transactionRollBack();
				$field['message'] = '<p class="msg-error">This URI already exists. Please try again.</p>';
				return $field;
			}

			$field['message'] = '<p class="msg-succes">Your changes have been saved successfully.</p>';

			// Commit transaction
			$this->pdbc->transactionCommit();
		}

		// Check changes
		if($field['content'] != $oldField['content'] || $field['template'] != $oldField['template']) {
			// Update page
			try {
				$this->pdbc->query('UPDATE `module_page`
				                    SET `id_template` = "' . $this->pdbc->quote($field['template']) . '",
				                        `content` = "' . $this->pdbc->quote($field['content']) . '"
				                    WHERE `id_router` = "'. $this->pdbc->quote($id) . '"');
			} catch(\lib\pdbc\PDBCException $e) {
				$field['message'] = '<p class="msg-error">Template doesn\'t exists. Please try again.</p>';
				return $field;
			}

			$field['message'] = '<p class="msg-succes">Your changes have been saved successfully.</p>';
		}

		return $field;
	}

	/**
	 *
	 */
	private function editPage($field) {
		// Parents
		$this->pdbc->query('SELECT `id`, `name`, `depth` FROM `router` WHERE `uri` NOT LIKE "' . $field['uri'] . '%" ORDER BY `uri` ASC');

		$parents = array('' => array('value' => 0));
		$number = 1;

		while($parent = $this->pdbc->fetch()) {
			$name = $number++ . '. ' . $this->markDepth($parent['name'], $parent['depth']);
			$value = array(
				'value' => $parent['id']
			);

			if($parent['id'] === $field['parent']) {
				$value['selected'] = 'selected';
			}

			$parents[$name] = $value;
		}

		// Templates
		$this->pdbc->query('SELECT `id`, `name` FROM `module_template` ORDER BY `id` ASC');

		$templates = array();

		while($template = $this->pdbc->fetch()) {
			$value = array(
				'value' => $template['id']
			);

			if($template['id'] === $field['template']) {
				$value['selected'] = 'selected';
			}

			$templates[$template['name']] = $value;
		}

		// Form
		$form = new \lib\html\HTMLFormStacked();

		// Page
		$form->openFieldset('Page');

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addTextarea('Content', $field['content'], array(
			'id' => 'form-content',
			'name' => 'content',
			'placeholder' => 'Content'
		));

		$form->closeFieldset();

		// Hierarchy
		$form->openFieldset('Hierarchy');

		$form->addSelect('Parent', $parents, array(
			'id' => 'form-parent',
			'name' => 'parent'
		));

		$form->addInput('Index', array(
			'type' => 'number',
			'id' => 'form-index',
			'name' => 'index',
			'placeholder' => 'Index',
			'value' => $field['index']
		));

		$form->closeFieldset();

		// Style
		$form->openFieldset('Style');

		$form->addSelect('Template', $templates, array(
			'id' => 'form-template',
			'name' => 'template'
		));

		$form->closeFieldset();

		$form->addContent('<a href="' . $this->url->getPath() . '?module=page' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-page">Edit page</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function removeGet($id) {
		return array(
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function removePost($id) {
		try {
			$this->pdbc->query('DELETE FROM `router` WHERE `id` = "' . $this->pdbc->quote($id) . '"');
		} catch(\lib\pdbc\PDBCException $e) {
			return array(
				'message' => '<p class="msg-error">Can\'t remove a page with children. Please try again after removing the children.</p>'
			);
		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=page', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function removePage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<p>Are you sure you want to remove this page? This action can\'t be undone!</p>');

		$form->addContent('<a href="' . $this->url->getPath() . '?module=page' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-template">Remove page</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function updateRouter($id) {
		// Update router
		$this->pdbc->query('UPDATE `router`
		                    LEFT JOIN `router` as `parent`
		                    ON `router`.`pid` = `parent`.`id`
		                    SET `router`.`depth` = CASE WHEN `router`.`pid` IS NULL THEN 0 ELSE `parent`.`depth` + 1 END,
		                        `router`.`uri` = CASE `router`.`root` WHEN 1
		                                         THEN "/"
		                                         ELSE CONCAT(CASE WHEN `router`.`pid` IS NULL
		                                                     THEN "/"
		                                                     ELSE CASE `parent`.`root`
		                                                          WHEN 0 THEN `parent`.`uri`
		                                                          ELSE CONCAT("/", REPLACE(LOWER(`router`.`name`), " ", "-"), "/")
		                                                          END
		                                                     END,
		                                                     REPLACE(LOWER(`router`.`name`), " ", "-"), "/")
		                                         END
		                    WHERE `router`.`id` = "' . $this->pdbc->quote($id) . '"');

		// Select children
		$this->pdbc->query('SELECT `id` FROM `router` as `r1` WHERE `pid` = "' . $this->pdbc->quote($id) . '"');

		foreach($this->pdbc->fetchAll() as $child) {
			!$this->updateRouter($child['id']);
		}
	}

	/**
	 *
	 */
	private function markDepth($name, $depth) {
		$result = $name;

		for($i = 0; $i < $depth; $i++) {
			$result = self::DEPTH_MARK . $result;
		}

		return $result;
	}
}

?>
