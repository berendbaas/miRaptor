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
	const DEFAULT_START_LEVEL = 0;
	const DEFAULT_END_LEVEL = -1;
	const DEFAULT_DEPTH = -1;

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\util\URL $url, $routerID, array $arguments) {
			parent::__construct($pdbc, $url, $routerID, $arguments);
			$this->isStatic = TRUE;
	}

	public function run() {
		// Get arguments
		$uri = $this->parseURI();
		$depth = $this->parseDepth();
		$startLevel = $this->parseStartLevel();
		$endLevel = $this->parseEndLevel();

		// Depth
		if($endLevel !== self::DEFAULT_END_LEVEL) {
			if($depth !== self::DEFAULT_DEPTH) {
				throw new \lib\core\ModuleException('The end level & depth cannot be specified at the same time.');
			}

			if($endLevel <= $startLevel) {
				throw new \lib\core\ModuleException('The end level must be larger then the start level');
			}

			$depth = $endLevel - $startLevel;
		}

		// Result
		$this->result = $this->getMenu($this->getID($uri, $startLevel), $depth);
	}

	/**
	 * Returns the depth argument or NULL, if none is given.
	 *
	 * @return string the depth argument or NULL, if none is given.
	 */
	private function parseURI() {
		if(isset($this->arguments['uri'])) {
			return $this->arguments['uri'];
		}

		return NULL;
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
	 * Returns the depth argument or the default argument, if none is given.
	 *
	 * @return string the depth argument or the default argument, if none is given.
	 */
	private function parseStartLevel() {
		if(isset($this->arguments['startLevel'])) {
			$startLevel = intval($this->arguments['startLevel']);

			return ($startLevel < 1) ? self::DEFAULT_START_LEVEL : $startLevel;
		}

		return self::DEFAULT_START_LEVEL;
	}

	/**
	 * Returns the depth argument or the default argument, if none is given.
	 *
	 * @return string the depth argument or the default argument, if none is given.
	 */
	private function parseEndLevel() {
		if(isset($this->arguments['endLevel'])) {
			$endLevel = intval($this->arguments['endLevel']);

			return ($endLevel < 1) ? self::DEFAULT_END_LEVEL : $endLevel;
		}

		return self::DEFAULT_END_LEVEL;
	}
	
	/**
	 * Returns the router ID that belongs to the given start leven & URI argument.
	 *
	 * @param  string                    $uri
	 * @param  int                       $startLevel
	 * @return int                       the router ID that belongs to the given start leven & URI argument.
	 * @throws \lib\core\ModuleException if the given URI doesn't exists.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function getID($uri, $startLevel) {
		// Check URI null
		if($uri === NULL) {
			return self::DEFAULT_ID;
		}

		// Check URI empty
		if($uri !== '') {
			$query = 'SELECT `id`, `pid`, `depth`
			          FROM `router`
			          WHERE `uri` = "' . $this->pdbc->quote($uri) . '"';
		} else {
			$query = 'SELECT `id`, `pid`, `depth`
			          FROM `router`
			          WHERE `id` = "' . $this->pdbc->quote($this->routerID) . '"';
		}

		// Fetch
		$this->pdbc->query($query);
		$current = $this->pdbc->fetch();

		// Check uri
		if(!$current) {
			throw new \lib\core\ModuleException('The URI doesn\'t exists.');
		}

		// Check startLevel
		if($current['depth'] < $startLevel) {
			throw new \lib\core\ModuleException('The start level can\'t be smaller then the uri level.');
		}

		// Find startLevel
		while($current['depth'] > $startLevel) {
			$this->pdbc->query('SELECT `id`, `pid`, `depth`
			                    FROM `router`
			                    WHERE `id` = "' . $this->pdbc->quote($current['pid']) . '"');

			$current = $this->pdbc->fetch();
		}

		return $current['id'];
	}

	/**
	 * Returns the menu with the given pid and depth.
	 *
	 * @param  int                     $pid
	 * @param  int                     $depth = self::DEPTH
	 * @return string                  the stylesheet with the given name and group.
	 * @throws \lib\pdbc\PDBCException if the given query can't be executed.
	 */
	private function getMenu($pid, $depth) {
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