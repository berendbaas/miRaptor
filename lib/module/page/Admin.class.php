<?php
namespace lib\module\page;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin extends \lib\core\AbstractAdmin {
	public function run() {
		$request = ($_SERVER['REQUEST_METHOD'] == 'POST') ? 'POST' : 'GET';
		$action = !isset($_GET['action']) ? 'Overview' : $_GET['action'];

		$function = $request . $action;
		if (method_exists($this, $function)) {
			$this->$function();
		} else {
			throw new \Exception('Action is not implemented', 501);
		}
	}

	private function getOverview()
	{
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
	
		$this->result .= <<<HTML
<h1>Pages</h1>
<table>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Uri</th>
	<th>Description</th>
	<th>Template</th>
	<th>Edit</th>
	<th>Remove</th>
</tr>
HTML;
		$this->pdbc->query('SELECT p.id as id, p.description as description, r.name as name, r.uri as uri, t.name as template FROM module_page AS p
								INNER JOIN router AS r
									ON r.id = p.rid 
								INNER JOIN template AS t
									ON t.id = r.tid');

		$pages = $this->pdbc->fetchAll();
		foreach ($pages as $no => $page) {
			$this->result .= <<<HTML
<tr>
	<td>{$page['id']}</td>
	<td>{$page['name']}</td>
	<td>{$page['uri']}</td>
	<td>{$page['description']}</td>
	<td>{$page['template']}</td>
	<td><a href="{$base}site?id={$id}&amp;module=page&amp;action=edit&amp;pid={$page['id']}" class="edititem" alt="Edit item">Edit</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=page&amp;action=remove&amp;pid={$page['id']}" class="removeitem" alt="Remove item">Remove</a></td>
</tr>
HTML;
		}
		$this->result .= <<<HTML
</table>
<a href="{$base}site?id={$id}&amp;module=page&amp;action=new">New Page</a>
HTML;
	}

	private function getEdit(array $fields = array())
	{
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		$pid = $this->pdbc->quote($_GET['pid']);
		$this->pdbc->query('SELECT p.id as id, 
								p.description as description, 
								r.name as name, 
								r.uri as uri, 
								t.name as template,
								t.id as templateID,
								p.content as content
							FROM module_page AS p
								INNER JOIN router AS r
									ON r.id = p.rid 
								INNER JOIN template AS t
									ON t.id = r.tid
							WHERE p.id = "'. $pid .'"');
		$item = $this->pdbc->fetch();

		$name = isset($fields['name']) ? $fields['name'] : $item['name'];
		$content = isset($fields['content']) ? $fields['content'] : $item['content'];
		$this->result .= <<<HTML
<h1>Edit Page</h1>
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name" value="{$name}" />
	<label for="template">Template</label>
	{$fields['template']}
	<select name="template">
HTML;
		$this->pdbc->query('SELECT * FROM template');
		foreach ($this->pdbc->fetchAll() as $no => $template) {
			if ($template['id'] == $item['templateID']) {
				$this->result .= <<<HTML
<option value="{$template['id']}" selected="selected">* {$template['name']}</option>
HTML;
			}
			else {
				$this->result .= <<<HTML
<option value="{$template['id']}">{$template['name']}</option>
HTML;
			}
		}
		$this->result .= <<<HTML
	</select>
	<label for="content">Content</label>
	<textarea name="content">{$content}</textarea>

	<a href="{$base}site?id={$id}&amp;module=page">Back</a>
	<input type="submit">
</form>
HTML;
	}

	private function postEdit()
	{

		$pid = $this->pdbc->quote($_GET['pid']);
		$content = $this->pdbc->quote($_POST['content']);
		$name = $this->pdbc->quote($_POST['name']);

		if(!$this->templateIDExists($_POST['template']))
		{
			$this->result .= <<<HTML
<p class="error">Failed to update page</p>
HTML;
			$this->getEdit(array(
					'content' => $_POST['content'],
					'name' => $_POST['name'],
					'template' => $_POST['template']
				));
			return;
		}
		$this->pdbc->query('UPDATE module_page as p
								JOIN router AS r
									ON r.id = p.rid
								JOIN template AS t
									ON t.id = r.tid
								SET p.content = "'. $content .'",
									r.name = "'. $name .'",
									r.tid = '. $this->pdbc->quote($_POST['template']) .'
								WHERE p.id = '. $pid);
		if ($this->pdbc->rowCount() == 0) {
			$this->result .= <<<HTML
<p class="error">Failed to update page.</p>
HTML;
		}

			$this->getEdit(array(
					'content' => $_POST['content'],
					'name' => $_POST['name'],
					'template' => $_POST['template']
			));
	}

	private function getNew(array $fields = array())
	{
		$base = $this->url->getURLDirectory();
		$name = isset($fields['name']) ? $fields['name'] : "";
		$template = isset($fields['template']) ? $fields['template'] : "";
		$uri = isset($fields['uri']) ? $fields['uri'] : "";
		$content = isset($fields['content']) ? $fields['content'] : "";

		$this->result .= <<<HTML
<h1>New Page</h1>
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name" value="{$fields['name']}"/>
	<label for="template">Template</label>
	<select name="template" value="{$template}">
HTML;
		$this->pdbc->query('SELECT * FROM template');
		foreach ($this->pdbc->fetchAll() as $no => $template) {
			$this->result .= <<<HTML
	<option value="{$template['id']}">{$template['name']}</opion>
HTML;
		}

		$this->result .= <<<HTML
	</select>
	<label for="content">Code</label>
	<textarea name="content">{$content}</textarea>

	<input type="submit" />
	<a href="">Back</a>
</form>
HTML;
	}

	private function postNew()
	{
		$name = $this->pdbc->quote($_POST['name']);
		$content = $this->pdbc->quote($_POST['content']);
		$template = $this->pdbc->quote($_POST['template']);

		if ($this->templateIDExists($_POST['template'])) {
			$this->pdbc->query('INSERT INTO router (pid, name, uri, tid) 
								VALUES (
									0,
									"'. $this->pdbc->quote($_POST['name']) .'",
									"/'. $this->pdbc->quote(strtolower($_POST['name'])) .'/",
									'. $template .'
									 )');

			$this->pdbc->query('SELECT LAST_INSERT_ID() as id FROM router');
			$rid = $this->pdbc->fetch()['id'];

			$this->pdbc->query('INSERT INTO module_page (rid, description, content)
								VALUES (
									'. $rid .',
									"Description",
									"'. $content .'"
									)');
		}
		else {
			$this->result .= <<<HTML
<p class="error">There was an error adding your page</p>
HTML;
			$this->getNew(array(
				'name' => $name,
				'content' => $content,
				'template' => $template
				));
		}
		$id = $_GET['id'];
		$base = $this->url->getURLDirectory();
		throw new \Exception($base . "site?id={$id}&module=page", 301);
	}

	private function getRemove()
	{
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		$this->pdbc->query('SELECT * FROM module_page 
							JOIN router 
								ON router.id = module_page.rid 
							WHERE module_page.id = '. $this->pdbc->quote($_GET['pid']));
		$page = $this->pdbc->fetch();
		$this->result .= <<<HTML
<h1>Removal notice</h1>
<p>You are about to remove the page "{$page['name']}"</p>
<p>Are you sure you want to remove this page? </p>
<form action="" method="POST">
<a href="{$base}site?id={$id}&amp;module=page">Back</a>
<input type="submit" value="Remove" />
</form>
HTML;
	}

	private function postRemove()
	{
		$this->pdbc->query('DELETE FROM module_page 
							USING module_page
							JOIN router
								ON router.id = module_page.rid
							WHERE module_page.id = ' . $this->pdbc->quote($_GET['pid']));
		$base =$this->url->getURLDirectory();
		throw new \Exception($base . "site?id={$id}&module=page", 301);
	}

	private function templateIDExists($id)
	{
		$this->pdbc->query('SELECT id from template where id = "'. $this->pdbc->quote($id) .'"');
		return $this->pdbc->rowCount() > 0;
	}

}

?>
