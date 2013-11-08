<?php
namespace lib\module\block;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	const DEFAULT_GROUP = '';

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, $routerID, array $arguments) {
			parent::__construct($pdbc, $url, $routerID, $arguments);
			$this->isParsable = TRUE;
			$this->isStatic = TRUE;
	}

	public function run() {
		$this->result = $this->getBlock($this->parseName(), $this->parseGroup());
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

		throw new \lib\core\ModuleException('name="" required.');
	}

	/**
	 * Returns the group argument or the default argument, if none is given.
	 *
	 * @return string the group argument or the default argument, if none is given.
	 */
	private function parseGroup() {
		if(isset($this->arguments['group'])) {
			return $this->arguments['group'];
		}

		return self::DEFAULT_GROUP;
	}

	/**
	 * Returns the block with the given name and group.
	 *
	 * @param  string                    $name
	 * @param  string                    $group = self::DEFAULT_GROUP
	 * @return string                    the block with the given name and group.
	 * @throws \lib\core\ModuleException if there is no block for the given name & group.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function getBlock($name, $group) {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_block`
		                    WHERE `name` = "' . $this->pdbc->quote($name) . '"
		                    AND `id_group` ' . ($group == self::DEFAULT_GROUP ? 'is NULL' : '= (SELECT `id`
		                                                                                        FROM `group`
		                                                                                        WHERE `name` = "' . $this->pdbc->quote($group) . '")'));

		$block = $this->pdbc->fetch();

		if(!$block) {
			throw new \lib\core\ModuleException('name="' . $name . '" does not exists.');
		}

		return end($block);
	}
}

?>