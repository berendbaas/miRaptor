<?php
namespace lib\module\menu;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function run() {
		$this->result = $this->parseMenu($this->parseId(), $this->parseDepth());
	}

	/**
	 *
	 */
	private function parseId() {
		if(isset($this->arguments['id'])) {
			$id = intval($this->arguments['id']);

			return ($id < 0) ? $this->routerID : $id;
		}

		return 0;
	}

	/**
	 *
	 */
	private function parseDepth() {
		if(isset($this->arguments['depth'])) {
			$depth = intval($this->arguments['depth']);

			return ($depth < 1) ? -1 : $depth;
		}

		return -1;
	}

	/**
	 *
	 */
	private function parseMenu($pid, $depth) {
		// Check depth
		if($depth == 0) {
			return '';
		}

		// Get router
		$this->pdbc->query('SELECT `id`,`name`,`uri`
		                    FROM `router`
		                    WHERE `pid` = ' . $pid . '
		                    ORDER BY `index` ASC');

		$router = $this->pdbc->fetchAll();

		// Stop command
		if(!$router) {
			return '';
		}

		// Parse menu
		$result = '';

		foreach($router as $route) {
			$current = ($this->routerID == $route['id'] ? ' class="current"' : '');

			$result .= PHP_EOL . <<<HTML
<li {$current}><a href="{$route['uri']}">{$route['name']}</a>{$this->parseMenu($route['id'], ($depth - 1))}</li>
HTML;
		}

		return <<<HTML
<ul>{$result}
</ul>
HTML;
	}
}

?>