<?php
namespace lib\module\menu;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
	const DEFAULT_ID = 0;
	const DEFAULT_DEPTH = -1;

	public function run() {
		$this->result = $this->getMenu($this->parseID(), $this->parseDepth());
	}

	/**
	 * Returns the router ID that belongs to the given URI argument.
	 *
	 * @param  string $uri
	 * @return int                       the router ID that belongs to the given URI argument.
	 * @throws \lib\core\ModuleException if the given URI doesn't exists.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function parseID() {
		// Uri isn't given
		if(!isset($this->arguments['uri'])) {
			return 0;
		}

		// Uri is empty
		if($this->arguments['uri'] == '') {
			return $this->routerID;
		}

		// Uri is given & not empty
		$this->pdbc->query('SELECT `id`
		                    FROM `router`
		                    WHERE `uri` = "' . $this->pdbc->quote($uri) . '"');

		$id = $this->pdbc->fetch();

		if(!$id) {
			throw new \ModuleException('uri="' . $uri . '" doesnt exists.');
		}

		return $id['id'];
	}

	/**
	 * Returns the depth argument or the default argument, if none is given.
	 *
	 * @return string the depth argument or the default argument, if none is given.
	 */
	private function parseDepth() {
		if(isset($this->arguments['depth'])) {
			$depth = intval($this->arguments['depth']);

			return ($depth < 1) ? self::DEFAULT_DEPTH : $depth;
		}

		return self::DEFAULT_DEPTH;
	}

	/**
	 * Returns the menu with the given pid and depth.
	 *
	 * @param  int                     $pid
	 * @param  int                     $depth = self::DEFAULT_DEPTH
	 * @return string                  the stylesheet with the given name and group.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private function getMenu($pid, $depth = self::DEFAULT_DEPTH) {
		if($depth != 0) {
			$this->pdbc->query('SELECT `id`,`name`,`uri`
			                    FROM `router`
			                    WHERE `pid` ' . ($pid == 0 ? 'IS NULL' : '= ' . $pid) . '
			                    ORDER BY `index` ASC');

			$router = $this->pdbc->fetchAll();

			if($router != array()) {
				$list = new \lib\html\HTMLList();

				foreach($router as $node) {
					$current = ($this->routerID == $node['id'] ? ' class="current"' : '');

					$list->addItem('<a' . $current . ' href="' . $node['uri'] . '">' . $node['name'] . '</a>' . $this->getMenu($node['id'], ($depth - 1)));
				}

				return $list->__toString();
			}
		}

		return '';
	}
}

?>