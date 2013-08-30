<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Menu implements ModuleInterface {
	private $pdbc;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, $page, array $args) {
		$this->pdbc = $pdbc;
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
		$pages = $this->pdbc->fetch('SELECT `id`,`name`,`description`,`url`
		                             FROM `pages`
		                             WHERE `pid` = ' . $pid .
		                            ' ORDER BY `order` ASC');

		if(empty($pages)) {
			return '';
		}

		// Parse menu
		$menu = '<ul>' . PHP_EOL;

		foreach($pages as $page) {
			$menu .= '<li' . ($this->page == $page['id'] ? ' class="current"' : '') .  '>
			             <a href="' . $page['url'] . '" alt="' . $page['description'] . '">' . $page['name'] . '</a>' .
			             $this->parseMenuDefault($page['id'], ($level - 1)) . 
			         '</li>' . PHP_EOL;
		}

		return $menu . '</ul>';
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
		$pages = $this->pdbc->fetch('SELECT `id`,`name`,`description`,`url`
		                             FROM `pages`
		                             WHERE `pid` = ' . $pid . '
		                             ORDER BY `order` ASC');

		if(empty($pages)) {
			return '';
		}

		// Parse menu
		$menu = '<ul>' . PHP_EOL;

		foreach($pages as $page) {
			$menu .= '<li' . ($this->page == $page['id'] ? ' class="current"' : '') .  '>
			            <a href="' . $page['url'] . '">' . $page['name'] . '<span>' . $page['description'] . '</span></a>' .
			            $this->parseMenuDescription($page['id'], ($level - 1)) .
			         '</li>' . PHP_EOL;
		}

		return $menu . '</ul>';
	}
}

?>