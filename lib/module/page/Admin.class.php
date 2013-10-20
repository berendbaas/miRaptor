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

	private function getOverview()
	{
		$this->result .= <<<HTML
<h1>Pages</h1>
<table>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Uri</th>
	<th>Edit</th>
	<th>Remove</th>
	<th></th>
</tr>
HTML;
		$this->pdbc->query('SELECT * FROM module_page 
								INNER JOIN router 
									ON router.id = module_page.rid 
								INNER JOIN template 
									ON template.id = router.tid');

		$pages = $this->pdbc->fetchAll();
		foreach ($pages as $no => $page) {
			$this->result .= <<<HTML 
<tr>
	<td>{$page['id']}</td>
	<td>{$page['name']}</td>
	<td>{$page['uri']}</td>
	<td></td>
	<td></td>

</tr>
HTML;
		}
	}

	private function getEdit()
	{

	}

	private function postEdit()
	{

	}

}

?>
