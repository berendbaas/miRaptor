<?php
namespace lib\module\template;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function run() {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_template`
		                    WHERE `id` = (SELECT `tid`
		                                  FROM `pages`
	                                          WHERE `id` = "' . $this->pdbc->quote($this->pageID) . '")');

		$template = $this->pdbc->fetch();

		if(!$template) {
			throw new \Exception('Template does not exists.');
		}

		$this->result = end($template);
	}
}

?>