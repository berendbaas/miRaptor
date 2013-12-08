<?php
namespace lib\module\template;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, $routerID, array $arguments) {
			parent::__construct($pdbc, $url, $routerID, $arguments);
			$this->isParsable = TRUE;
			$this->isStatic = TRUE;
	}

	public function run() {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_template`
		                    WHERE `id` = (SELECT `id_template`
		                                  FROM `module_page`
	                                          WHERE `id_router` = "' . $this->pdbc->quote($this->routerID) . '")');

		$this->result = end($this->pdbc->fetch());
	}
}

?>