<?php
namespace lib\module\javascript;

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

	private function getOverview() {
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		$this->result .= <<<HTML
<h1>Javascript</h1>
<table>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Edit</th>
	<th>Remove</th>
</tr>
HTML;
		$this->pdbc->query('SELECT * FROM module_javascript');
		$scripts = $this->pdbc->fetchAll();
		foreach ($scripts as $no => $script) {
			$this->result .= <<<HTML
<tr>
	<td>{$script['id']}</td>
	<td>{$script['name']}</td>
	<td><a href="{$base}site?id={$id}&amp;module=javascript&amp;action=edit&amp;sid={$script['id']}">Edit</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=javascript&amp;action=remove&amp;sid={$script['id']}">Remove</a></td>
</tr>
HTML;
		}
		$this->result .= <<<HTML
</table>
<a href="{$base}site?id={$id}&amp;module=javascript&amp;action=new">New Script</a>
HTML;
	}

	private function getNew(array $fields = array())
	{
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];

		$name = isset($fields['name']) ? $fields['name'] : "";
		$content = isset($fields['content']) ? $fields['content'] : "";

		$this->result .= <<<HTML
<h1>New Script</h1>
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name" value="{$name}" />
	<label for="content">Code</label>
	<textarea name="content">{$content}</textarea>
	<a href="{$base}site?id={$id}&amp;module=javascript">Back</a>
	<input type="submit" />
</form>
HTML;
	}

	private function postNew()
	{
		$base = $this->url->getURLPath();
		$id = $_GET['id'];

		$this->pdbc->query('INSERT INTO module_javascript 
							(name, content)
							VALUES
							("'. $this->pdbc->quote($_POST['name']) .'", "'. $this->pdbc->quote($_POST['content']) .'")');
		throw new \Exception($base . "?id={$id}&module=javascript", 301);
	}

	private function getEdit(array $fields = array())
	{
		$base = $this->url->getURLPath();
		$id = $_GET['id'];

		$this->pdbc->query('SELECT *
							FROM module_javascript
							WHERE id = "' . $this->pdbc->quote($_GET['sid']) . '"');
		$item = $this->pdbc->fetch();

		$name = isset($fields['name']) ? $fields['name'] : $item['name'];
		$content = isset($fields['content']) ? $fields['content'] : $item['content'];

		$this->result .= <<<HTML
<h1>Edit Script</h1>
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name" value="{$name}" />
	<label for="content">Code</label>
	<textarea name="content">{$content}</textarea>
	<a href="{$base}?id={$id}&amp;module=block">Back</a>
	<input type="submit" />
</form>
HTML;
	}

	private function postEdit()
	{
		$this->pdbc->query('UPDATE module_javascript
							SET name = "'. $this->pdbc->quote($_POST['name']) .'",
								content = "'. $this->pdbc->quote($_POST['content']) .'"
								WHERE id = '. $this->pdbc->quote($_GET['sid']));

		if ($this->pdbc->rowCount() == 0) {
			$this->result .= <<<HTML
<p class="error">There was an error saving your block</p>
HTML;
			$this->getEdit(array(
					'name' => $_POST['name'],
					'content' => $_POST['content']
					));
			return;
		}
		$this->getEdit();
	}

	private function getRemove()
	{
		$base = $this->url->getURLPath();
		$id = $_GET['id'];

		$this->pdbc->query('SELECT *
								FROM module_javascript
								WHERE id=' . $this->pdbc->quote($_GET['sid']));
		$script = $this->pdbc->fetch();

		$this->result .= <<<HTML
<h1>Removal notice</h1>
<p>You are about to remove the script "{$script['name']}"</p>
<p>Are you sure you want to remove this page?</p>
<form action="" method="POST">
	<a href="{$base}id={$id}&amp;module=javascript">Back</a>
	<input type="submit" value="Remove" />
</form>
HTML;
	}


	private function postRemove()
	{
		$base = $this->url->getURLPath();
		$id = $_GET['id'];

		$this->pdbc->query('DELETE FROM module_javascript
							WHERE id ='. $this->pdbc->quote($_GET['sid']));
		throw new \Exception($base . "?id={$id}&module=javascript", 301);
	}
}