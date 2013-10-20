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
		$pid = $this->parseId();
		$levels = $this->parseLevel();

		switch($this->parseStyle()) {
			case 'description':
				$this->result = $this->parseMenuDescription($pid, $levels);
			break;
			default:
				$this->result = $this->parseMenuDefault($pid, $levels);
			break;
		}
	}

	/**
	 *
	 */
	private function parseId() {
		if(isset($this->arguments['id'])) {
			$id = intval($this->arguments['id']);

			return ($id < 0) ? $this->pageID : $id;
		}

		return 0;
	}

	/**
	 *
	 */
	private function parseLevel() {
		if(isset($this->arguments['levels'])) {
			$level = intval($this->arguments['levels']);

			return ($level < 1) ? -1 : $level;
		}

		return -1;
	}

	/**
	 *
	 */
	private function parseStyle() {
		if(isset($this->arguments['style'])) {
			return $this->arguments['style'];
		}

		return '';
	}

	/**
	 *
	 */
	private function parseMenuDefault($pid, $level) {
		// Check levels
		if($level == 0) {
			return '';
		}

		// Get pages
		$this->pdbc->query('SELECT `id`,`name`,`uri`
		                    FROM `router`
		                    WHERE `pid` = ' . $pid . '
		                    ORDER BY `index` ASC');

		$pages = $this->pdbc->fetchAll();

		if(!$pages) {
			return '';
		}

		// Parse menu
		$result = '';

		foreach($pages as $page) {
			$current = ($this->pageID == $page['id'] ? ' class="current"' : '');

			$result .= PHP_EOL . <<<HTML
<li {$current}><a href="{$page['uri']}">{$page['name']}</a>{$this->parseMenuDefault($page['id'], ($level - 1))}</li>
HTML;
		}

		return <<<HTML
<ul>{$result}
</ul>
HTML;
	}

	/**
	 *
	 */
	private function parseMenuDescription($pid, $level) {
		// Check levels
		if($level == 0) {
			return '';
		}

		// Get pages
		$this->pdbc->query('SELECT `id`,`name`,`uri`
		                    FROM `router`
		                    WHERE `pid` = ' . $pid . '
		                    ORDER BY `index` ASC');

		$pages = $this->pdbc->fetchAll();

		if(!$pages) {
			return '';
		}

		// Parse menu
		$result = '';

		foreach($pages as $page) {
			$current = ($this->pageID == $page['id'] ? ' class="current"' : '');

			$result .= PHP_EOL . <<<HTML
<li {$current}><a href="{$page['uri']}">{$page['name']}<span></span></a>{$this->parseMenuDefault($page['id'], ($level - 1))}</li>
HTML;
		}

		return <<<HTML
<ul>{$result}
</ul>
HTML;
	}
}

?>