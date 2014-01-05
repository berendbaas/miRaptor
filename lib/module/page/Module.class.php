<?php
namespace lib\module\page;

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
		switch($this->parseGet()) {
			case "title":
				$this->result = $this->getTitle();
			break;
			case "content":
				$this->result = $this->getContent();
			break;
			default:
				throw new \lib\core\ModuleException('get="' . $this->arguments['get']. '" is not supported.');
			break;
		}
	}

	/**
	 * Returns the get argument, if one is given.
	 *
	 * @return string                    the get argument, if one is given.
	 * @throws \lib\core\ModuleException if the get argument isn't given.
	 */
	private function parseGet() {
		if(isset($this->arguments['get'])) {
			return $this->arguments['get'];
		}

		throw new \lib\core\ModuleException('get="" required.');
	}

	/**
	 * Returns the title of the current page.
	 *
	 * @return string                    the title of the current page.
	 * @throws \lib\core\ModuleException if the title doesn't exists.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function getTitle() {
		$this->pdbc->query('SELECT `name`
		                    FROM `router`
		                    WHERE `id`=' . $this->pdbc->quote($this->routerID));

		$title = $this->pdbc->fetch();

		if(!$title) {
			throw new \lib\core\ModuleException('Title does not exists.');
		}

		return end($title);
	}

	/**
	 * Returns the content of the current page.
	 *
	 * @return string                    the content of the current page.
	 * @throws \lib\core\ModuleException if the content doesn't exists.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function getContent() {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_page`
		                    WHERE `id_router` = ' .  $this->pdbc->quote($this->routerID));

		$content = $this->pdbc->fetch();

		if(!$content) {
			throw new \lib\core\ModuleException('Content does not exists.');
		}

		return end($content);
	}
}

?>