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
		$this->pdbc->query('INSERT INTO `module_block` (`id_theme`, `name`, `content`)
		                    SELECT `id`, "' . $this->pdbc->quote($_POST['name']) . '", "' . $this->pdbc->quote($_POST['block']) . '"
		                    FROM `module_theme`
		                    WHERE `name` = "' . $this->pdbc->quote($_POST['theme']) . '"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=block', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
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

		$form->addTextarea('Block', '', array(
			'id' => 'form-block',
			'name' => 'block',
			'placeholder' => 'Block'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=block' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-block">New block</h2>' . $message . $form->__toString();

	}

	/**
	 *
	 */
	private function postEdit($id) {
		$this->pdbc->query('UPDATE `module_block`
		                    SET `id_theme` = (SELECT `id`
		                                      FROM `module_theme`
		                                      WHERE `name` = "' . $this->pdbc->quote($_POST['theme']) . '"),
		                        `name` = "'. $this->pdbc->quote($_POST['name']) .'",
		                        `content` = "'. $this->pdbc->quote($_POST['block']) .'"
		                    WHERE `id` = "'. $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=block', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getEdit($id, $message = '') {
		$this->pdbc->query('SELECT `theme`.`name` as `theme`, `module_block`.`name`, `module_block`.`content`
		                    FROM `module_block`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `module_block`.`id_theme` = `theme`.`id`
		                    WHERE `module_block`.`id` = "' . $this->pdbc->quote($id) . '"');

		$block = $this->pdbc->fetch();

		$this->pdbc->query('SELECT `name` FROM `module_theme`');

		$themes = array();

		while($theme = $this->pdbc->fetch()) {
			$themes[$theme['name']] = array(
				'value' => $theme['name']
			) + ($theme['name'] == $block['theme'] ? array('selected' => 'selected') : array());
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
			'value' => $block['name']
		));

		$form->addTextarea('Block', $block['content'], array(
			'id' => 'form-block',
			'name' => 'block',
			'placeholder' => 'Block'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=block' . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-block">Edit block</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function postRemove($id) {
		$this->pdbc->query('DELETE FROM `module_block` WHERE `id` = "' . $this->pdbc->quote($id) .'"');

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'] .  '&module=block', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	private function getRemove($id, $message = '') {
		$form = new \lib\html\HTMLFormStacked();

		$form->addContent('<label>Are you sure you want to remove this block? This action can\'t be undone!</label>');

		$form->addContent('<a href="' . $this->url->getPath() . '?id=' . $_GET['id'] .  '&amp;module=block' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-block">Remove block</h2>' . $message . $form->__toString();
	}

	/**
	 *
	 */
	private function getOverview() {
		$this->pdbc->query('SELECT `module_block`.`id`, `module_block`.`name`, `theme`.`name` AS `theme`
		                    FROM `module_block`
		                    LEFT JOIN (SELECT `id`, `name`
		                               FROM `module_theme`) AS `theme`
		                    ON `module_block`.`id_theme` = `theme`.`id`
		                    WHERE 1');

		$blocks = $this->pdbc->fetchAll();

		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Theme','Edit','Remove'));

		foreach($blocks as $block) {
			$table->openRow();
			$table->addColumn($block['id']);
			$table->addColumn($block['name']);
			$table->addColumn($block['theme']);
			$table->addColumn('<a class="icon icon-edit" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=block&amp;action=' . self::ACTION_EDIT . '&amp;tid=' . $block['id'] . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=block&amp;action=' . self::ACTION_REMOVE . '&amp;tid=' . $block['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-block">Block</h2>' . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?id=' . $_GET['id'] . '&amp;module=block&amp;action=' . self::ACTION_NEW . '&amp;tid=0">New block</a></p>';
	}
}

?>
