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
	private $request;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\Request $request, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->request = $request;
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
		$this->result = <<<HTML
<ul>{$this->parseBreadcrumb($this->page)}</ul>
HTML;
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
		$breadcrumb = end($this->pdbc->fetch('SELECT `pid`,`name`,`uri`
		                                      FROM `pages`
		                                      WHERE `id` = "' . $this->pdbc->quote($id) . '"'));

		return empty($breadcrumb) ? PHP_EOL : $this->parseBreadcrumb($breadcrumb['pid']) . <<<HTML
<li><a href="{$breadcrumb['uri']}">{$breadcrumb['name']}</a></li>

HTML;
	}
}

?>
