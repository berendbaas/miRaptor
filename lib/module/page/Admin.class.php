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
				// TODO
			break;
		}
	}

	/**
	 *
	 */
	private function postNew($id) {
		$this->pdbc->query('INSERT IGNORE INTO `router` (`pid`,`index`,`name`,`uri`)
		                    SELECT CASE COUNT(`r1`.`id`) WHEN 0 THEN NULL ELSE `r1`.`id` END,
		                           MAX(`r2`.`index`) + 1,
		                           "' . $this->pdbc->quote($_POST['name']) . '",
		                           CONCAT(CASE COUNT(`r1`.`id`)
		                                  WHEN 0 THEN "/"
		                                  ELSE CASE `r1`.`root`
		                                       WHEN 1 THEN CONCAT("/", LOWER(`r1`.`name`) ,"/")
		                                       WHEN 0 THEN `r1`.`uri`
		                                       END
		                                  END,
		                                  "' . strtolower($this->pdbc->quote($_POST['name'])) . '/")
		                    FROM `router` AS `r1`, `router` AS `r2`
		                    WHERE `r1`.`name` = "' . $this->pdbc->quote($_POST['parent']) . '"');

		if(!$this->pdbc->rowCount()) {
			return '<p class="msg-error">This page already exists. Please try again.</p>';
		}

		$this->pdbc->query('INSERT INTO `module_page` (`id_router`,`id_template`,`content`)
		                    SELECT "' . $this->pdbc->insertID() . '",
		                           `module_template`.`id`,
		                           "' . $this->pdbc->quote($_POST['content']) . '"
		                    FROM `module_template`
		                    WHERE `module_template`.`name` = "' . $_POST['template'] . '"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=page', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getNew($id, $message = '') {
		// Parents
		$this->pdbc->query('SELECT `name` FROM `router`');

		$parents = array('');

		while($parent = $this->pdbc->fetch()) {
			$parents[] = $parent['name'];
		}

		// Templates
		$this->pdbc->query('SELECT `name` FROM `module_template`');

		$templates = array();

		while($template = $this->pdbc->fetch()) {
			$templates[] = $template['name'];
		}

		// Form
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name'
		));

		$form->addSelect('Parent', $parents, array(
			'id' => 'form-parent',
			'name' => 'parent'
		));

		$form->addTextarea('Content', '', array(
			'id' => 'form-content',
			'name' => 'content',
			'placeholder' => 'Content'
		));

		$form->addSelect('Template', $templates, array(
			'id' => 'form-template',
			'name' => 'template'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=page' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-page">New page</h2>' . $message . $form->__toString();

	}

	/**
	 *
	 */
	private function postEdit($id) {
		$this->pdbc->query('UPDATE `module_page`
		                    SET `content` = "'. $this->pdbc->quote($_POST['content']) .'"
		                    WHERE `id` = "'. $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=page', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getEdit($id, $message = '') {
		// Parents
		$this->pdbc->query('SELECT `name` FROM `router`');

		$parents = array('');

		while($parent = $this->pdbc->fetch()) {
			$parents[] = $parent['name'];
		}

		// Templates
		$this->pdbc->query('SELECT `name` FROM `module_template`');

		$templates = array();

		while($template = $this->pdbc->fetch()) {
			$templates[] = $template['name'];
		}

		// Edit
		$this->pdbc->query('SELECT `module_page`.`content`, `router`.`name`, `router`.`uri`
		                    FROM `module_page`
		                    LEFT JOIN (SELECT `id`,`name`,`uri`
		                               FROM `router`) AS `router`
		                    ON `module_page`.`id_router` = `router`.`id`
		                    WHERE `module_page`.`id` = "' . $this->pdbc->quote($id) . '"');

		$page = $this->pdbc->fetch();

		// Form
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $page['name']
		));

		$form->addSelect('Parent', $parents, array(
			'id' => 'form-parent',
			'name' => 'parent'
		));

		$form->addInput('Uri', array(
			'type' => 'text',
			'id' => 'form-uri',
			'name' => 'uri',
			'placeholder' => 'Uri',
			'value' => $page['uri'],
			'disabled' => 'disabled'
		));

		$form->addTextarea('Content', $page['content'], array(
			'id' => 'form-content',
			'name' => 'content',
			'placeholder' => 'Content'
		));

		$form->addSelect('Template', $templates, array(
			'id' => 'form-template',
			'name' => 'template'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=page' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-page">Edit page</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function postRemove($id) {
		$this->pdbc->query('DELETE FROM `router` 
		                    WHERE `id` = (SELECT `id_router`
		                                  FROM `module_page`
						  WHERE `id` = "' . $this->pdbc->quote($id) . '")');

		if(!$this->pdbc->rowCount()) {

		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=page', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getRemove($id, $message = '') {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<label>Are you sure you want to remove this page? This action can\'t be undone!</label>');

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=page' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-page">Remove page</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function getOverview() {
		$this->pdbc->query('SELECT `module_page`.`id`, `router`.`name`, `router`.`uri`
		                    FROM `module_page`
		                    LEFT JOIN (SELECT `id`,`name`,`uri`
		                               FROM `router`) AS `router`
		                    ON `module_page`.`id_router` = `router`.`id`');

		$pages = $this->pdbc->fetchAll();

		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Uri','Edit','Remove'));

		foreach($pages as $test => $page) {
			$table->openRow();
			$table->addColumn($page['id']);
			$table->addColumn($page['name']);
			$table->addColumn($page['uri']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=page&amp;action=' . self::ACTION_EDIT . '&amp;tid=' . $page['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=page&amp;action=' . self::ACTION_REMOVE . '&amp;tid=' . $page['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-page">Page</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=page&amp;action=' . self::ACTION_NEW . '&amp;tid=0">New page</a></p>';
	}
}

?>
