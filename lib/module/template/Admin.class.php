<?php
namespace lib\module\template;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin extends \lib\core\AbstractAdmin {
	public function run() {
		$request = ($_SERVER['REQUEST_METHOD'] == 'GET') ? 'GET' : 'POST';
		$action = !isset($_GET['action']) ? 'Overview' : $_GET['action'];

		$function = $request . $action;
		if (method_exists($this, $function)) {
			$this->$function();	
		} else {
			throw new \Exception('Action is not implemented', 501);
		}
	}

	private function getOverview() {
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		$this->result .= <<<HTML
<h1>Template</h1>
<table>
<tr>
	<th>ID</td>
	<th>Name</th>
	<th>Edit</th>
	<th>Remove</th>
</tr>
HTML;

		$this->pdbc->query('SELECT * FROM template');
		$templates = $this->pdbc->fetchAll();
		foreach ($templates as $key => $template) {
			$this->result .= <<<HTML
<tr>
	<td>{$template['id']}</td>
	<td>{$template['name']}</td>
	<td><a href="{$base}site?id={$id}&amp;module=template&amp;action=edit&amp;tid={$template['id']}" class="edit">Edit</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=template&amp;action=remove&amp;tid={$template['id']}" class="edit">Remove</a></td>
</tr>
HTML;
		}
		$this->result .= <<<HTML
</table>
<a href="{$base}site?id={$id}&amp;module=template&amp;action=new" class="addnew">Add new template</a>
HTML;
	}


	private function getEdit(array $fields = array()) {
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		$this->pdbc->query('SELECT *
							FROM template
							WHERE id = "'. $this->pdbc->quote($_GET['tid']) .'"');
		$item = $this->pdbc->fetch();
		$name = isset($fields['name']) ? $fields['name'] : $item['name'];
		$content = isset($fields['content']) ? $fields['content'] : $item['content'];

		$this->result .= <<<HTML
<h1>Edit Template</h1>
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name" value="{$name}">
	<label for="content">Template</label>
	<textarea name="content">{$content}</textarea>
	<a href="{$base}site?id={$id}&amp;module=template">Back</a>
	<input type="submit">
</form>
HTML;
	}

	private function postEdit() {
		$this->pdbc->query('UPDATE `template`
							SET `name` = "'. $this->pdbc->quote($_POST['name']) .'",
							`content` = "'. $this->pdbc->quote($_POST['content']) .'"
							WHERE `id` = "'. $this->pdbc->quote($_GET['tid']) .'"');
		if ($this->pdbc->rowCount() == 0) {
			$this->getEdit(array(
					'name' => $_GET['name'],
					'content' => $_GET['content']
				));
			return;
		}
		$this->getEdit();
	}

	private function getNew() {
		$this->result .= <<<HTML
<h1>New Template</h1>
<form action="" method="POST">
	<label for="name">Nam	e</label>
	<input type="text" name="name">
	<label for="content">Code</label>
	<textarea name="content"></textarea>

	<input type="submit">
</form>
HTML;
	}

	private function postNew() {
		$this->pdbc->query('INSERT INTO `template` (`name`, `content`) 
							VALUES ("'. $this->pdbc->quote($_POST['name']) .
								'", "'. $this->pdbc->quote($_POST['content']) .'")');

		$this->redirectOverview();
	}

	private function getRemove() {
		$id = $_GET['id'];
		$base = $this->url->getURLDirectory();
		$this->result .= <<<HTML
<p>Are you sure you want to remove this template? This can not be undone!</p>
<form action="" method="POST">
	<a href="{$base}site?id={$id}&amp;module=template">Back</a>
	<input type="submit" value="delete">
</form>
HTML;
	}

	private function postRemove() {
		$this->pdbc->query('DELETE FROM template WHERE `id` = "' . $this->pdbc->quote($_GET['tid']) .'"');

		$this->getRemove();
	}


	private function redirectOverview() {
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		throw new \Exception($base . "site?id={$id}&module=template", 301);
	}

}

?>
