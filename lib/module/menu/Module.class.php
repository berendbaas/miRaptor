<?php
namespace lib\module\menu;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	const DEFAULT_DEPTH = -1;
	const DEFAULT_URI = '/';

	public function run() {
		// $this->result = $this->getMenu($this->parseId($this->parseURI()), $this->parseDepth());
	}

	/**
	 *
	 */
	private function parseURI() {
		if(isset($this->arguments['uri'])) {
			return $this->arguments['uri'];
		}

		return self::DEFAULT_URI;
	}

	/**
	 *
	 */
	private function parseID($uri) {
		$this->pdbc->query('');

		$id = $this->fetch();

		if(!$id) {
			throw new \Exception();
		}

		return 0;
	}

	/**
	 *
	 */
	private function parseDepth() {
		if(isset($this->arguments['depth'])) {
			$depth = intval($this->arguments['depth']);

			return ($depth < 1) ? self::DEFAULT_DEPTH : $depth;
		}

		return self::DEFAULT_DEPTH;
	}

	/**
	 *
	 */
	private function getMenu($pid, $depth) {
		// Check depth
		if($depth == 0) {
			return '';
		}

		// Get router
		$this->pdbc->query('SELECT `id`,`name`,`uri`
		                    FROM `router`
		                    WHERE `pid` ' . ($pid == 0 ? 'IS NULL' : '= ' . $pid) . '
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
<li><a{$current} href="{$route['uri']}">{$route['name']}</a>{$this->parseMenu($route['id'], ($depth - 1))}</li>
HTML;
		}

		return <<<HTML
<ul>{$result}
</ul>
HTML;
	}
}

?>