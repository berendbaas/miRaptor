<?php
namespace lib\module\site;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	public function run() {
		$this->result = $this->parseSite($this->parseGet());
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
	private function parseSite($get) {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_site`
		                    WHERE `name` = "' . $this->pdbc->quote($get) . '"');

		$site = $this->pdbc->fetch();

		if(!$site) {
			throw new \Exception('get="' . $get . '" does not exists.');
		}

		return end($site);
	}
}

?>