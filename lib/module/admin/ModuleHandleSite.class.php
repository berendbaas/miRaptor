<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleSite extends ModuleHandleAbstract {
	const ADMIN_CLASS = '\\Admin';
	const ADMIN_NAMESPACE = 'lib\\modules\\';

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, array $args, \lib\core\User $user) {
		parent::__construct($pdbc, $url, $args, $user);
		$this->hasAccessWebsite();
	}

	/**
	 *
	 */
	private function hasAccessWebsite() {
		if(!isset($_GET['id'])) {
			throw new \Exception($this->url->getURLBase() . Module::PAGE_OVERVIEW, 301);
		}

		$this->pdbc->query('SELECT `db`
		                    FROM `website`
		                    WHERE `id` = ' . $this->pdbc->quote($_GET['id']) . '
		                    AND`uid` = ' . $this->pdbc->quote($this->user->getUserID()));

		$db = $this->pdbc->fetch();

		if(!$db) {
			throw new \Exception($this->url->getURLBase() . Module::PAGE_OVERVIEW, 301);
		}

		$this->pdbc->selectDatabase(end($db));
	}

	/**
	 *
	 */
	public function content() {
		if($this->hasAccessModule()) {
			$module = self::ADMIN_NAMESPACE . $_GET['module'] . self::ADMIN_CLASS;

			$result = new $module($this->pdbc, $this->url);
			$result->run();

			return $result->__toString();
		}

		return 'TODO module overzicht';
	}

	/**
	 *
	 */
	private function hasAccessModule() {
		if(!isset($_GET['module'])) {
			return FALSE;
		}

		$this->pdbc->query('SELECT `id`
		                    FROM `modules`
		                    WHERE `name` = "' . $_GET['module'] . '"');

		$id = $this->pdbc->fetch();

		return !empty($id);
	}

	/**
	 *
	 */
	public function logBox() {
		$overview = $this->url->getDirectory() . Module::PAGE_OVERVIEW;
		$logout = $this->url->getDirectory() . Module::PAGE_LOGOUT;

		return <<<HTML
<ul>
	<li><a href="{$overview}">Overview</a></li>
	<li><a href="{$logout}">Logout</a></li>
</ul>
HTML;
	}

	/**
	 *
	 */
	public function menu() {
		$this->pdbc->query('SELECT `name` FROM `modules`');

		$modules = $this->pdbc->fetchAll();
		$result = '';

		foreach($modules as $module) {
			$href = $this->url->getURLBase() . Module::PAGE_SITE . '?id=' . $_GET['id'] . '&amp;module=' . $module['name'];

			$result .= PHP_EOL . <<<HTML
	<li><a href="{$href}">{$module['name']}</a></li>
HTML;
		}

		return <<<HTML
<h2>Modules</h2>
<ul>{$result}
</ul>
HTML;
	}
}

?>
