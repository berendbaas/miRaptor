<?php
namespace lib\module\breadcrumb;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function run() {
		$this->result = <<<HTML
<ul>{$this->parseBreadcrumb($this->routerID)}
</ul>
HTML;
	}

	/**
	 *
	 */
	private function parseBreadcrumb($id) {
		$this->pdbc->query('SELECT `pid`,`name`,`uri`
		                    FROM `router`
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"');

		$breadcrumb = $this->pdbc->fetch();

		return !$breadcrumb ? '' : $this->parseBreadcrumb($breadcrumb['pid']) . PHP_EOL . <<<HTML
<li><a href="{$breadcrumb['uri']}">{$breadcrumb['name']}</a></li>
HTML;
	}
}

?>
