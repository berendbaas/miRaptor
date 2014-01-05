<?php
namespace lib\module\template;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\util\URL $url, $routerID, array $arguments) {
			parent::__construct($pdbc, $url, $routerID, $arguments);
			$this->isParsable = TRUE;
			$this->isStatic = TRUE;
	}

	public function run() {
		$this->pdbc->query('SELECT `template`.`content`
		                    FROM `module_template` as `template`
		                    JOIN `module_page` as `page`
		                    ON `template`.`id` = `page`.`id_template`
		                    WHERE `page`.`id_router` = "' . $this->pdbc->quote($this->routerID) . '"
		                    LIMIT 1');

		$template = $this->pdbc->fetch();

		if($template === NULL) {
			throw new \lib\core\ModuleException('Does not exists.');
		}

		$this->result = end($template);
	}
}

?>