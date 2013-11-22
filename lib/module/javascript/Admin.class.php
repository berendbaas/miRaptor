<?php
namespace lib\module\javascript;

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
		$this->pdbc->query('INSERT INTO `module_javascript` (`id_theme`, `name`, `content`)
		                    SELECT `id`, "' . $this->pdbc->quote($_POST['name']) . '", "' . $this->pdbc->quote($_POST['javascript']) . '"
		                    FROM `module_theme`
		                    WHERE `name` = "' . $this->pdbc->quote($_POST['theme']) . '"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=javascript', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
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

		$form->addTextarea('Javascript', '', array(
			'id' => 'form-javascript',
			'name' => 'javascript',
			'placeholder' => 'Javascript'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=javascript' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-javascript">New javascript</h2>' . $message . $form->__toString();

	}

	/**
	 *
	 */
	private function postEdit($id) {
		$this->pdbc->query('UPDATE `module_javascript`
		                    SET `id_theme` = (SELECT `id`
		                                      FROM `module_theme`
		                                      WHERE `name` = "' . $this->pdbc->quote($_POST['theme']) . '"),
		                        `name` = "'. $this->pdbc->quote($_POST['name']) .'",
		                        `content` = "'. $this->pdbc->quote($_POST['javascript']) .'"
		                    WHERE `id` = "'. $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=javascript', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getEdit($id, $message = '') {
		$this->pdbc->query('SELECT `theme`.`name` as `theme`, `module_javascript`.`name`, `module_javascript`.`content`
		                    FROM `module_javascript`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `module_javascript`.`id_theme` = `theme`.`id`
		                    WHERE `module_javascript`.`id` = "' . $this->pdbc->quote($id) . '"');

		$javascript = $this->pdbc->fetch();

		$this->pdbc->query('SELECT `name` FROM `module_theme`');

		$themes = array();

		while($theme = $this->pdbc->fetch()) {
			$themes[$theme['name']] = array(
				'value' => $theme['name']
			) + ($theme['name'] == $javascript['theme'] ? array('selected' => 'selected') : array());
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
			'value' => $javascript['name']
		));

		$form->addTextarea('Javascript', $javascript['content'], array(
			'id' => 'form-javascript',
			'name' => 'javascript',
			'placeholder' => 'Javascript'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=javascript' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-javascript">Edit javascript</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function postRemove($id) {
		$this->pdbc->query('DELETE FROM `module_javascript` WHERE `id` = "' . $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=javascript', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getRemove($id, $message = '') {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<label>Are you sure you want to remove this javascript? This action can\'t be undone!</label>');

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=javascript' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-javascript">Remove javascript</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function getOverview() {
		$this->pdbc->query('SELECT `module_javascript`.`id`, `module_javascript`.`name`, `theme`.`name` AS `theme`
		                    FROM `module_javascript`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `module_javascript`.`id_theme` = `theme`.`id`
		                    WHERE 1');

		$javascripts = $this->pdbc->fetchAll();

		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Theme','Edit','Remove'));

		foreach($javascripts as $javascript) {
			$table->openRow();
			$table->addColumn($javascript['id']);
			$table->addColumn($javascript['name']);
			$table->addColumn($javascript['theme']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=javascript&amp;action=' . self::ACTION_EDIT . '&amp;tid=' . $javascript['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=javascript&amp;action=' . self::ACTION_REMOVE . '&amp;tid=' . $javascript['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-javascript">Javascript</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=javascript&amp;action=' . self::ACTION_NEW . '&amp;tid=0">New javascript</a></p>';
	}
}

?>
