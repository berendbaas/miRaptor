<?php
namespace lib\modules\stylesheet;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin implements \lib\core\AdminInterface {
	private $pdbc;
	private $url;
	private $result;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\URL $url) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->result = '';
	}


	private function getOverview()
	{
		$base = $this->url->getURLBase();
		$id = $_GET['id'];
		$this->result .= 'Hello Stylesheets';
		$this->result .= <<<HTML
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
	<td><a href="{$base}site?id={$id}&amp;module=stylesheet&amp;action=edit&amp;tid={$sheet['id']}" class="edititem" alt="edit item">Edit</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=stylesheet&amp;action=remove&amp;tid={$sheet['id']}" class="removeitem" alt="Remove item">Remove</a></td>
	<td><a href="{$base}site?id={$id}&amp;module=stylesheet&amp;action=remove&amp;tid={$sheet['id']}" class="renameitem" alt="Rename item"></a></td>
</tr>
HTML;
		}
		$this->result .= <<<HTML
</table>
<a href="{$base}site?id={$id}&amp;module=stylesheet&amp;action=new" class="addnew">Add new stylesheet</a>
HTML;

	}


	private function getRemove()
	{
		$id = $_GET['id'];
		$tid = $this->pdbc->quote($_GET['tid']);
		$base = $this->url->getURLBase();
		$this->result .= <<<HTML
<p>Are you sure you want to remove this stylesheet? This can not be undone!<p>
<form action="" method="POST">
	<a href="{$base}site?id={$id}&amp;module=stylesheet">Back</a>
	<input type="submit" value="Delete">
</form>
HTML;
	}

	private function postRemove()
	{
		$tid = $this->pdbc->quote($_GET['tid']);
		$base = $this->url->getURLBase();
		$this->pdbc->query('DELETE FROM module_stylesheet WHERE id ="'. $tid .'"');

		$id = $_GET['id'];
		throw new \Exception($base . "site?id={$id}&module=stylesheet", 301);
	}

	private function getEdit()
	{
		$base = $this->url->getURLBase();
		$tid = $this->pdbc->quote($_GET['tid']);
		$id = $_GET['id'];
		$this->pdbc->query('SELECT * 
							FROM module_stylesheet
							WHERE id = "' . $tid . '"');
		$item = $this->pdbc->fetch();
		$this->result .= <<<HTML
<form action="" method="POST">
	<label for="name">Name</label><input type="text" name="name" value="{$item['name']}">
	<label for="content">Style</label><textarea name="content">
{$item['content']}
	</textarea>
	<a href="{$base}site?id={$id}&amp;module=stylesheet">Back</a>
	<input type="submit">
</form>
HTML;
	}


	private function postEdit()
	{
		$id = $this->pdbc->quote($_GET['tid']);

		$name = $this->pdbc->quote($_POST['name']);
		$content = $this->pdbc->quote($_POST['content']);

		$this->pdbc->query('UPDATE `module_stylesheet`
							SET `name` = "' . $name .  '",
							`content` = "' . $content . '"
							WHERE `id` = ' . $id . '
							');
		$this->getEdit();
	}

	private function getNew()
	{
		$this->result .= <<<HTML
<form action="" method="POST">
	<label for="name">Name</label>
	<input type="text" name="name">
	<label for="content">Content</label>
	<textarea name="content"></textarea>

	<input type="submit">
</form>
HTML;
	}

	private function postNew()
	{
		$name = $this->pdbc->quote($_POST['name']);
		$content = $this->pdbc->quote($_POST['content']);
		$this->pdbc->query('INSERT INTO module_stylesheet (name, content) values ("'. $name .'", "'. $content .'")');
	

		$base = $this->url->getURLBase();
		$id = $_GET['id'];
		throw new \Exception($base . "site?id={$id}&module=stylesheet", 301);
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->result;

	}

	/**
	 *
	 */
	public function run() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$request = 'POST';
		} else {
			$request = 'GET';
		}

		if (!isset($_GET['action'])) {
			$action = 'Overview';
		} else {
			$action = $_GET['action'];
		}

		$function = $request . $action;
		$this->$function();
	}
}

?>