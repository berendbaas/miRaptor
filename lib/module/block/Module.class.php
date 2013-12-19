<?php
namespace lib\module\block;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, $routerID, array $arguments) {
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
	 * Returns the block with the given name and theme.
	 *
	 * @param  string                    $name
	 * @param  string                    $theme = NULL
	 * @return string                    the block with the given name and theme.
	 * @throws \lib\core\ModuleException if there is no block for the given name and theme.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function get($name, $theme = NULL) {
		//
		if($theme === NULL) {
			$query = 'SELECT `block`.`content`
			          FROM `module_block` as `block`
			          LEFT JOIN `module_template` as `template`
			          ON `template`.`id_theme` = `block`.`id_theme`
			          LEFT JOIN `module_page` as `page`
			          ON `page`.`id_template` = `template`.`id`
			          WHERE `block`.`name` = "' . $this->pdbc->quote($name) . '"
			          AND `page`.`id_router` = "' . $this->pdbc->quote($this->routerID) . '"
				  LIMIT 1';
			$query = 'SELECT `block`.`content`
			          FROM `module_block` as `block`
			          LEFT JOIN `module_theme` as `theme`
			          ON `theme`.`id` = `block`.`id_theme`
			          WHERE `block`.`name` = "' . $this->pdbc->quote($name) . '"
			          AND `theme`.`name` = "' . $this->pdbc->quote($theme) . '"
				  LIMIT 1';
		}

		$this->pdbc->query($query);

		$block = $this->pdbc->fetch();

		if($block === NULL) {
			throw new \lib\core\ModuleException('Does not exists.');
		}

		return end($block);
	}
}

?>