<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageSite extends ModulePageAbstract {
	const ADMIN_CLASS = '\\Admin';
	const ADMIN_NAMESPACE = 'lib\\module\\';

	private static $sitePdbc;
	
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, array $arguments, \lib\core\User $user) {
		parent::__construct($pdbc, $url, $arguments, $user);

		if(!isset($this->sitePdbc)) {
			if(!isset($_GET['id']) || !$this->hasAccess($_GET['id'])) {
				throw new \lib\core\StatusCodeException($this->url->getURLDirectory() . Module::PAGE_DASHBOARD, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			}

			$this->pdbc->query('SELECT `db`
			                    FROM `website`
			                    WHERE `id` = ' . $this->pdbc->quote($_GET['id']) . '
			                    AND `uid` = ' . $this->pdbc->quote($this->user->getID()));

			$this->sitePdbc = clone $pdbc;
			$this->sitePdbc->selectDatabase(end($this->pdbc->fetch()));
		}
	}

	public function content() {
		if(!isset($_GET['module'])) {
			return 'TODO Website dashboard';
		}

		if(!$this->moduleExists($_GET['module'])) {
			throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?id=' . $_GET['id'], \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$admin = self::ADMIN_NAMESPACE . $_GET['module'] . self::ADMIN_CLASS;
		$result = new $admin($this->sitePdbc, $this->url);
		$result->run();

		return $result->__toString();
	}

	/**
	 *
	 */
	private function moduleExists($name) {
		$this->sitePdbc->query('SELECT `id`
		                        FROM `module`
		                        WHERE `name` = "' . $this->pdbc->quote($name) . '"');

		return $this->sitePdbc->fetch() ? TRUE : FALSE;
	}

	public function logBox() {
		$list = new \lib\html\HTMLList();

		$list->addItem('<a class="icon icon-dashboard" href="' . $this->url->getDirectory() . Module::PAGE_DASHBOARD . '">Dashboard</a>');
		$list->addItem('<a class="icon icon-sign-out" href="' . $this->url->getDirectory() . Module::PAGE_SIGN_OUT . '">Sign Out</a>');

		return $list->__toString();
	}

	public function menu() {
		$this->sitePdbc->query('SELECT `id`,`name` FROM `module_admin_group`');

		$groups = $this->sitePdbc->fetchAll();
		$result = '';

		foreach($groups as $group) {
			$result .= '<h2 class="icon icon-group-' . $group['name'] . '">' . ucfirst($group['name']) . '</h2>' . PHP_EOL . $this->subMenu($group['id']);
		}

		return $result;
	}

	/**
	 *
	 */
	private function subMenu($groupID) {
		$this->sitePdbc->query('SELECT `module`.`name`
		                        FROM `module`
		                        RIGHT JOIN (SELECT `id_module`
		                                    FROM `module_admin`
		                                    WHERE `active` = "1"
		                                    AND `id_group` = "' . $this->pdbc->quote($groupID) . '") AS `admin`
		                        ON `module`.`id` = `admin`.`id_module`
		                        ORDER BY `module`.`name` ASC');

		$modules = $this->sitePdbc->fetchAll();
		$list = new \lib\html\HTMLList();

		foreach($modules as $module) {
			$list->addItem('<a href="' . $this->url->getURLPath() . '?id=' . $_GET['id'] . '&amp;module=' . $module['name'] . '">' . ucfirst($module['name']) . '</a>');
		}

		return $list->__toString();
	}
}

?>
