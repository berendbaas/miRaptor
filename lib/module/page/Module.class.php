<?php
namespace lib\module\page;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function run() {
		switch($this->parseGet()) {
			case "content":
				$this->result = $this->parseContent();
			break;
			case "description":
				$this->result = $this->parseDescription();
			break;
			case "title":
				$this->result = $this->parseTitle();
			break;
			default:
				throw new \Exception('get="' . $this->arguments['get']. '" does not exists.');
			break;
		}
	}

	/**
	 *
	 */
	private function parseGet() {
		if(isset($this->arguments['get'])) {
			return $this->arguments['get'];
		}

		throw new \Exception('get="" required.');
	}

	/**
	 *
	 */
	private function parseContent() {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_page`
		                    WHERE `id_router` = ' .  $this->pdbc->quote($this->routerID));

		$content = $this->pdbc->fetch();

		if(!$content) {
			throw new \Exception('Content does not exists.');
		}

		return end($content);
	}

	/**
	 *
	 */
	private function parseDescription() {
		$this->pdbc->query('SELECT `description`
		                    FROM `module_page`
		                    WHERE `id_router`=' .  $this->pdbc->quote($this->routerID));

		$description = $this->pdbc->fetch();

		if(!$description) {
			throw new \Exception('Description does not exists.');
		}

		return end($description);
	}

	/**
	 *
	 */
	private function parseTitle() {
		$this->pdbc->query('SELECT `name`
		                    FROM `router`
		                    WHERE `id`=' . $this->pdbc->quote($this->routerID));

		$title = $this->pdbc->fetch();

		if(!$title) {
			throw new \Exception('Title does not exists.');
		}

		return end($title);
	}
}

?>