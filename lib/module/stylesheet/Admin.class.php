<?php
namespace lib\module\stylesheet;

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
<h1>Stylesheet</h1>
<table>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Edit</th>
	<th>Remove</th>
</td>
HTML;

		$this->pdbc->query('SELECT * FROM module_stylesheet');
		$sheets = $this->pdbc->fetchAll();
		foreach ($sheets as $no => $sheet) {
			$this->result .= <<<HTML
<tr>
	<td>{$sheet['id']}</td>
	<td>{$sheet['name']}</td>
	<td><a href="{$base}site?id={$id}&amp;module=stylesheet&amp;action=edit&amp;sid={$sheet['id']}" class="edititem" alt="edit item">Edit</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=stylesheet&amp;action=remove&amp;sid={$sheet['id']}" class="removeitem" alt="Remove item">Remove</a></td>
</tr>
HTML;
		}
		$this->result .= <<<HTML
</table>
<a href="{$base}site?id={$id}&amp;module=stylesheet&amp;action=new" class="addnew">Add new stylesheet</a>
HTML;

	}


	private function getRemove() {
		$id = $_GET['id'];
		$base = $this->url->getURLDirectory();
		$sheet = $this->pdbc->query('SELECT name from module_stylesheet WHERE id =' . $this->pdbc->quote($_GET['sid']))->fetch();
		$this->result .= <<<HTML
<p>You are about to remove the stylesheet {$sheet['name']}</p>
<p>Are you sure you want to remove this stylesheet? This can not be undone!<p>
<form action="" method="POST">
	<a href="{$base}site?id={$id}&amp;module=stylesheet">Back</a>
	<input type="submit" value="Delete" />
</form>
HTML;
	}

	private function postRemove() {
		$this->pdbc->query('DELETE FROM module_stylesheet WHERE id ="'. $this->pdbc->quote($_GET['sid']) .'"');

		$this->redirectOverview();
	}

	private function getEdit(array $fields = array()) {
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];

		$this->pdbc->query('SELECT * 
							FROM module_stylesheet
							WHERE id = "' . $this->pdbc->quote($_GET['sid']) . '"');
		$item = $this->pdbc->fetch();

		$name = isset($fields['name']) ? $fields['name'] : $item['name'];
		$content = isset($fields['content']) ? $fields['content'] : $item['content'];

		$this->result .= <<<HTML
<h1>Edit Stylesheet</h1>
<form action="" method="POST">
	<label for="name">Name</label><input type="text" name="name" value="{$name}">
	<label for="content">Style</label><textarea name="content">
{$content}
	</textarea>
	<a href="{$base}site?id={$id}&amp;module=stylesheet">Back</a>
	<input type="submit" />
</form>
HTML;
	}


	private function postEdit() {
		$this->pdbc->query('UPDATE `module_stylesheet`
							SET `name` = "' . $this->pdbc->quote($_POST['name']) .  '",
							`content` = "' . $this->pdbc->quote($_POST['content']) . '"
							WHERE `id` = ' . $this->pdbc->quote($_GET['sid']) . '
							');
		if ($this->pdbc->rowCount() == 0) {
			$this->getEdit(array(
					'name' => $_POST['name'],
					'content' => $_POST['content']
				));
			return;
		}
		$this->getEdit();
	}

	private function getNew() {
		$this->result .= <<<HTML
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name" />
	<label for="content">Content</label>
	<textarea name="content"></textarea>

	<input type="submit" />
</form>
HTML;
	}

	private function postNew() {
		$this->pdbc->query('INSERT 
								INTO module_stylesheet (name, content) 
								VALUES ("'. $this->pdbc->quote($_POST['name']) .
									'", "'. $this->pdbc->quote($_POST['content']) .'")');

		$this->redirectOverview();
	}

	private function redirectOverview()
	{
		$base = $this->url->getURLDirectory();
		$id = $_GET['id'];
		throw new \Exception($base . "site?id={$id}&module=stylesheet", 301);
	}
}

?>