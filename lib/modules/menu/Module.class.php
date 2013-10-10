<?php
namespace lib\modules\menu;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module implements \lib\core\ModuleInterface {
	private $pdbc;
	private $url;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\URL $url, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->page = $page;
		$this->args = $args;
		$this->result = '';
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
	public function isStatic() {
		return TRUE;
	}

	/**
	 *
	 */
	public function isNamespace() {
		return FALSE;
	}

	/**
	 *
	 */
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
		if(isset($this->args['id'])) {
			$id = intval($this->args['id']);

			return ($id < 0) ? $this->page : $id;
		}

		return 0;
	}

	/**
	 *
	 */
	private function parseLevel() {
		if(isset($this->args['levels'])) {
			$level = intval($this->args['levels']);

			return ($level < 1) ? -1 : $level;
		}

		return -1;
	}

	/**
	 *
	 */
	private function parseStyle() {
		if(isset($this->args['style'])) {
			return $this->args['style'];
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
		$this->pdbc->query('SELECT `id`,`name`,`description`,`uri`
		                    FROM `pages`
		                    WHERE `pid` = ' . $pid . '
		                    ORDER BY `order` ASC');

		$pages = $this->pdbc->fetchAll();

		if(!$pages) {
			return '';
		}

		// Parse menu
		$result = '';

		foreach($pages as $page) {
			$current = ($this->page == $page['id'] ? ' class="current"' : '');

			$result .= PHP_EOL . <<<HTML
<li {$current}><a href="{$page['uri']}" title="{$page['description']}">{$page['name']}</a>{$this->parseMenuDefault($page['id'], ($level - 1))}</li>
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
		$this->pdbc->query('SELECT `id`,`name`,`description`,`uri`
		                    FROM `pages`
		                    WHERE `pid` = ' . $pid . '
		                    ORDER BY `order` ASC');

		$pages = $this->pdbc->fetchAll();

		if(!$pages) {
			return '';
		}

		// Parse menu
		$result = '';

		foreach($pages as $page) {
			$current = ($this->page == $page['id'] ? ' class="current"' : '');

			$result .= PHP_EOL . <<<HTML
<li {$current}><a href="{$page['uri']}" title="{$page['description']}">{$page['name']}<span>{$page['description']}</span></a>{$this->parseMenuDefault($page['id'], ($level - 1))}</li>
HTML;
		}

		return <<<HTML
<ul>{$result}
</ul>
HTML;
	}
}

?>