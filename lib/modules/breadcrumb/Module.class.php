<?php
namespace lib\modules\breadcrumb;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module implements \lib\core\ModuleInterface {
	private $pdbc;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, $page, array $args) {
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
		return FALSE;
	}

	/**
	 *
	 */
	public function run() {
		$this->result = '<ul>' . $this->parseBreadcrumb($this->page) . '</ul>';
	}

	/**
	 *
	 */
	private function parseId() {
		if(isset($this->args['id'])) {
			return intval($this->args['id']);
		}

		return 0;
	}

	/**
	 *
	 */
	private function parseBreadcrumb($id) {
		// Fetch
		$breadcrumb = end($this->pdbc->fetch('SELECT `pid`,`name`,`url`
		                                      FROM `pages`
		                                      WHERE `id` = "' . $this->pdbc->quote($id) . '"'));

		// Stop
		if(empty($breadcrumb)) {
			return PHP_EOL;
		}

		// HTML
		return $this->parseBreadcrumb($breadcrumb['pid']) .
		       '<li><a href="' . $breadcrumb['url'] . '">' . $breadcrumb['name'] . '</a></li>' . PHP_EOL;
	}
}

?>