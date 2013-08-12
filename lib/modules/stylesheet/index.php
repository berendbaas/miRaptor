<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @version 1.0
 */
class Stylesheet implements Module {
	private $pdbc;
	private $page;
	private $args;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->page = $page;
		$this->args = $args;
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
	public function get() {
		// Query
		$query = '(SELECT `tid` FROM `pages` WHERE `id` = "' . $this->pdbc->quote($this->page) . '")'; // Get template id
		$query = '(SELECT `sid`,`order` FROM `module_stylesheet_template` WHERE `tid` = ' . $query . ')'; // Get stylesheet id's
		$query = '(SELECT `name`, `content` FROM `module_stylesheet` RIGHT JOIN ' . $query . ' AS `stylesheets` ON `module_stylesheet`.`id` = `stylesheets`.`sid` ORDER BY `order` ASC)'; // Get stylesheets

		// Fetch
		$stylesheets = $this->pdbc->fetch($query);

		// HTML
		$result = '';

		foreach($stylesheets as $stylesheet) {
			$result .= PHP_EOL . '/* ' . $stylesheet['name'] . ' start */' . PHP_EOL
				. $stylesheet['content'] . PHP_EOL
				. '/* ' . $stylesheet['name'] . ' end */' . PHP_EOL; 
		}

		return '<style>' . $result . '</style>';
	}
}

?>