<?php
namespace lib\module\javascript;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\util\URL $url, $routerID, array $arguments) {
			parent::__construct($pdbc, $url, $routerID, $arguments);
			$this->isStatic = TRUE;
	}

	public function run() {
		$this->result = $this->get($this->parseName(), $this->parseTheme());
	}

	/**
	 * Returns the name argument, if one is given.
	 *
	 * @return string                    the name argument, if one is given.
	 * @throws \lib\core\ModuleException if the name argument isn't given.
	 */
	private function parseName() {
		if(isset($this->arguments['name'])) {
			return $this->arguments['name'];
		}

		throw new \lib\core\ModuleException('Name required.');
	}

	/**
	 * Returns the theme argument or null, if none is given.
	 *
	 * @return string the theme argument or null, if none is given.
	 */
	private function parseTheme() {
		if(isset($this->arguments['theme'])) {
			return $this->arguments['theme'];
		}

		return NULL;
	}

	/**
	 * Returns the javascript with the given name and theme.
	 *
	 * @param  string                    $name
	 * @param  string                    $theme = NULL
	 * @return string                    the javascript with the given name and theme.
	 * @throws \lib\core\ModuleException if there is no javascript for the given name and theme.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function get($name, $theme = NULL) {
		if($theme === NULL) {
			$query = 'SELECT `javascript`.`content`
			          FROM `module_javascript` as `javascript`
			          LEFT JOIN `module_template` as `template`
			          ON `template`.`id_theme` = `javascript`.`id_theme`
			          LEFT JOIN `module_page` as `page`
			          ON `page`.`id_template` = `template`.`id`
			          WHERE `javascript`.`name` = "' . $this->pdbc->quote($name) . '"
			          AND `page`.`id_router` = "' . $this->pdbc->quote($this->routerID) . '"
				  LIMIT 1';
		} else {
			$query = 'SELECT `javascript`.`content`
			          FROM `module_javascript` as `javascript`
			          LEFT JOIN `module_theme` as `theme`
			          ON `theme`.`id` = `javascript`.`id_theme`
			          WHERE `javascript`.`name` = "' . $this->pdbc->quote($name) . '"
			          AND `theme`.`name` = "' . $this->pdbc->quote($theme) . '"
				  LIMIT 1';
		}

		$this->pdbc->query($query);

		$javascript = $this->pdbc->fetch();

		if($javascript === NULL) {
			throw new \lib\core\ModuleException('Does not exists.');
		}

		return <<<HTML
<script>
/* {$name} start */
{$javascript['content']}
/* {$name} end */
</script>
HTML;
	}
}

?>