<?php
namespace lib\module\stylesheet;

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
		$this->pdbc->query('INSERT INTO `module_stylesheet` (`id_theme`, `name`, `content`)
		                    SELECT `id`, "' . $this->pdbc->quote($_POST['name']) . '", "' . $this->pdbc->quote($_POST['stylesheet']) . '"
		                    FROM `module_theme`
		                    WHERE `name` = "' . $this->pdbc->quote($_POST['theme']) . '"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=stylesheet', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getNew($id, $message = '') {
		$this->pdbc->query('SELECT `name` FROM `module_theme`');

		$themes = array();

		while($theme = $this->pdbc->fetch()) {
			$themes[] = $theme['name'];
		}

		$form = new \lib\html\HTMLFormStacked();

		$form->addSelect('Theme', $themes, array(
			'id' => 'form-theme',
			'name' => 'theme'
		));

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name'
		));

		$form->addTextarea('Stylesheet', '', array(
			'type' => 'text',
			'id' => 'form-stylesheet',
			'name' => 'stylesheet',
			'placeholder' => 'Stylesheet'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=stylesheet' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-stylesheet">New stylesheet</h2>' . $message . $form->__toString();

	}

	/**
	 *
	 */
	private function postEdit($id) {
		$this->pdbc->query('UPDATE `module_stylesheet`
		                    SET `id_theme` = (SELECT `id`
		                                      FROM `module_theme`
		                                      WHERE `name` = "' . $this->pdbc->quote($_POST['theme']) . '"),
		                        `name` = "'. $this->pdbc->quote($_POST['name']) .'",
		                        `content` = "'. $this->pdbc->quote($_POST['stylesheet']) .'"
		                    WHERE `id` = "'. $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=stylesheet', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getEdit($id, $message = '') {
		$this->pdbc->query('SELECT `theme`.`name` as `theme`, `module_stylesheet`.`name`, `module_stylesheet`.`content`
		                    FROM `module_stylesheet`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `module_stylesheet`.`id_theme` = `theme`.`id`
		                    WHERE `module_stylesheet`.`id` = "' . $this->pdbc->quote($id) . '"');

		$stylesheet = $this->pdbc->fetch();

		$this->pdbc->query('SELECT `name` FROM `module_theme`');

		$themes = array();

		while($theme = $this->pdbc->fetch()) {
			$themes[$theme['name']] = array(
				'value' => $theme['name']
			) + ($theme['name'] == $stylesheet['theme'] ? array('selected' => 'selected') : array());
		}

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
			'value' => $stylesheet['name']
		));

		$form->addTextarea('Stylesheet', $stylesheet['content'], array(
			'type' => 'text',
			'id' => 'form-stylesheet',
			'name' => 'stylesheet',
			'placeholder' => 'Stylesheet'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=stylesheet' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-stylesheet">Edit stylesheet</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function postRemove($id) {
		$this->pdbc->query('DELETE FROM `module_stylesheet` WHERE `id` = "' . $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=stylesheet', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getRemove($id, $message = '') {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<label>Are you sure you want to remove this stylesheet? This action can\'t be undone!</label>');

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=stylesheet' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-stylesheet">Remove stylesheet</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function getOverview() {
		$this->pdbc->query('SELECT `module_stylesheet`.`id`, `module_stylesheet`.`name`, `theme`.`name` AS `theme`
		                    FROM `module_stylesheet`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `module_stylesheet`.`id_theme` = `theme`.`id`
		                    WHERE 1');

		$stylesheets = $this->pdbc->fetchAll();

		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Theme','Edit','Remove'));

		foreach($stylesheets as $stylesheet) {
			$table->openRow();
			$table->addColumn($stylesheet['id']);
			$table->addColumn($stylesheet['name']);
			$table->addColumn($stylesheet['theme']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=stylesheet&amp;action=' . self::ACTION_EDIT . '&amp;tid=' . $stylesheet['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=stylesheet&amp;action=' . self::ACTION_REMOVE . '&amp;tid=' . $stylesheet['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-stylesheet">Stylesheet</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=stylesheet&amp;action=' . self::ACTION_NEW . '&amp;tid=0">New stylesheet</a></p>';
	}
}

?>
