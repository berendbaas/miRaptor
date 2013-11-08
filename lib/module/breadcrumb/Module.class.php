<?php
namespace lib\module\breadcrumb;

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
		$this->result = $this->getBreadcrumb($this->routerID);

	}

	/**
	 * Returns the breadcrumbs starting at the given ID.
	 *
	 * @param  int                       $id
	 * @return String                    the breadcrumbs starting at the given ID.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function getBreadcrumb($id) {
		$list = new \lib\html\HTMLList();

		while($breadcrumb = $this->fetchBreadcrumb($id)) {
			$list->addItem('<a href="' . $breadcrumb['uri'] . '">' . $breadcrumb['name'] .'</a>');
			$id = $breadcrumb['id'];
		}

		return $list->__toString();
	}

	/**
	 * Returns an array with with the pid, name & uri of breadcrumb with the given ID.
	 *
	 * @param  int                       $id
	 * @return array                     an array with with the pid, name & uri of breadcrumb with the given ID.
	 * @throws \lib\pdbc\PDBCException   if the given query can't be executed.
	 */
	private function fetchBreadcrumb($id) {
		$this->pdbc->query('SELECT `pid`,`name`,`uri`
		                    FROM `router`
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"');

		return $this->pdbc->fetch();
	}
}

?>
