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
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$request = 'GET';
		} else {
			$request = 'POST';
		}

		if (!isset($_GET['action'])) {
			$action = 'Overview';
		} else {
			$action = $_GET['action'];
		}

		$function = $request . $action;
		$this->$function();
	}


	private function getOverview()
	{
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
	<th>Rename</th>
</tr>
HTML;

		$this->pdbc->query('SELECT * FROM module_template');
		$templates = $this->pdbc->fetchAll();
		foreach ($templates as $key => $template) {
			$this->result .= <<<HTML
<tr>
	<td>{$template['id']}</td>
	<td>{$template['name']}</td>
	<td><a href="{$base}site?id={$id}&amp;module=template&amp;action=edit&amp;tid={$template['id']}" class="edit">Edit</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=template&amp;action=remove&amp;tid={$template['id']}" class="edit">Remove</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=template&amp;action=rename&amp;tid={$template['id']}" class="edit">Rename</a></td>
</tr>
HTML;
		}
		$this->result .= <<<HTML
</table>
<a href="{$base}site?id={$id}&amp;module=template&amp;action=new" class="addnew">Add new template</a>
HTML;
	}


	private function getEdit()
	{
		$base = $this->url->getURLDirectory();
		$tid = $this->pdbc->quote($_GET['tid']);
		$id = $_GET['tid'];
		$this->pdbc->query('SELECT *
							FROM module_template
							WHERE id = "'. $tid .'"');
		$item = $this->pdbc->fetch();
		$content = $item['content'];
		$this->result .= <<<HTML
<h1>Edit Template</h1>
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name" value="{$item['name']}">
	<label for="content">Template</label>
	<textarea name="content">{$content}</textarea>
	<a href="{$base}site?id={$id}&amp;module=template">Back</a>
	<input type="submit">
</form>
HTML;
	}

	private function postEdit()
	{
		$id = $this->pdbc->quote($_GET['tid']);

		$name = $this->pdbc->quote($_POST['name']);
		$content = $this->pdbc->quote($_POST['content']);

		$this->pdbc->query('UPDATE `module_template`
							SET `name` = "'. $name .'",
							`content` = "'. $content .'"
							WHERE `id` = "'. $id .'"');

		$this->getEdit();
	}

	private function getNew()
	{
		$this->result .= <<<HTML
<h1>New Template</h1>
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name">
	<label for="content"></label>
	<textarea name="content"></textarea>

	<input type="submit">
</form>
HTML;
	}

	private function postNew()
	{
		$name = $this->pdbc->quote($_POST['name']);
		$content = $this->pdbc->quote($_POST['content']);
		$this->pdbc->query('INSERT INTO `module_template` (`name`, `content`) values ("'. $name .'", "'. $content .'")');

		$this->redirectOverview();
	}

	private function getRemove()
	{
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

	private function postRemove()
	{
		$tid = $this->pdbc->quote($_GET['tid']);
		$this->pdbc->query('DELETE FROM module_template WHERE `id` = "' . $tid .'"');

		$this->getRemove();
	}


	private function redirectOverview()
	{
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		throw new \Exception($base . "site?id={$id}&module=template", 301);
	}

}

?>