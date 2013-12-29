<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageWebsite extends ModulePageAbstract {
	const ADMIN_CLASS = '\\Admin';
	const ADMIN_NAMESPACE = 'lib\\module\\';

	private $website;

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, $redirect) {
		parent::__construct($pdbc, $url, $redirect);
		$this->init();
		
		$this->isNamespace = TRUE;
	}

	/**
	 *
	 */
	private function init() {
		$this->website = new \lib\core\Website($this->pdbc, $this->user, $this->url->getFile());

		// Check user & website
		if(!$this->user->isSignedIn() || !$this->website->hasAccess()) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->pdbc->query('SELECT `db`
		                    FROM `website`
		                    WHERE `id` = ' . $this->pdbc->quote($this->website->getID()) . '
		                    AND `uid` = ' . $this->pdbc->quote($this->user->getID()));

		$database = $this->pdbc->fetch();

		// Check database
		if($database === NULL) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->pdbc = clone $this->pdbc;
		$this->pdbc->selectDatabase($database['db']);
	}

	public function run() {
		$this->result = '<div id="menu"><nav>' . $this->menu()  . '</nav></div><div id="content">' . $this->content() . '</div>';
	}

	/**
	 *
	 */
	private function menu() {
		$this->pdbc->query('SELECT `id`,`name` FROM `module_admin_group`');

		$groups = $this->pdbc->fetchAll();
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
		$this->pdbc->query('SELECT `module`.`name`
		                        FROM `module`
		                        RIGHT JOIN (SELECT `id_module`
		                                    FROM `module_admin`
		                                    WHERE `active` = "1"
		                                    AND `id_group` = "' . $this->pdbc->quote($groupID) . '") AS `admin`
		                        ON `module`.`id` = `admin`.`id_module`
		                        ORDER BY `module`.`name` ASC');

		$modules = $this->pdbc->fetchAll();
		$list = new \lib\html\HTMLList();

		foreach($modules as $module) {
			$list->addItem('<a href="' . $this->url->getURLPath() . '?module=' . $module['name'] . '">' . ucfirst($module['name']) . '</a>');
		}

		return $list->__toString();
	}

	/**
	 *
	 */
	private function content() {
		// Check module get
		if(!isset($_GET['module'])) {
			return '<h2>Website</h2><p>Comming soon.</p>';
		}

		$module = $_GET['module'];

		$this->pdbc->query('SELECT `id`
		                    FROM `module`
		                    WHERE `name` = "' . $this->pdbc->quote($module) . '"');

		// Check module exists
		if($this->pdbc->fetch() === NULL) {
			throw new \lib\core\StatusCodeException($this->url->getURLPath(), \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$admin = self::ADMIN_NAMESPACE . $_GET['module'] . self::ADMIN_CLASS;

		$result = new $admin($this->pdbc, $this->url, $this->user, $this->website);
		$result->run();
		return $result->__toString();
	}
}

?>
