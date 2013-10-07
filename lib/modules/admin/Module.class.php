<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module implements \lib\core\ModuleInterface {
	const USER_DB = 'miraptor_cms';

	const PAGE_LOGIN = '';
	const PAGE_LOGOUT = 'logout';
	const PAGE_OVERVIEW = 'overview';
	const PAGE_SETTINGS = 'settings';
	const PAGE_SITE = 'site';

	const OVERVIEW_RENAME = 'rename';
	const OVERVIEW_DOMAIN = 'domain';
	const OVERVIEW_ACTIVE = 'active';

	private $pdbc;
	private $request;
	private $page;
	private $args;
	private $result;

	private $userPdbc;
        private $user;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\Request $request, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->request = $request;
		$this->page = $page;
		$this->args = $args;
		$this->result = '';

		include('config.php');
		$this->userPdbc = new \lib\core\Mysql($config['mysql']);
		$this->userPdbc->selectDatabase(self::USER_DB);
		$this->user = new \lib\core\User($this->userPdbc);
	}

	/**
	 *
	 */
	public function __toString() {
		return $this->result;
	}

	/**
	 *
	 */
	public function isStatic() {
		return FALSE;
	}

	/**
	 *
	 */
	public function isNamespace() {
		return TRUE;
	}

	/**
	 *
	 */
	public function run() {
		if($this->user->isLoggedIn()) {
			$this->result = $this->handleAdmin();
		} else {
			$this->result = $this->handleLogin();
		}
	}

	/**
	 *
	 */
	private function handleLogin() {
		if($this->request->getUri()->getFilename() != self::PAGE_LOGIN) {
			$this->redirect(self::PAGE_LOGIN);
		}

		$message = '';

		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($this->user->login($_POST['username'], $_POST['password'])) {
				$this->redirect(self::PAGE_OVERVIEW);
			}

			$message = <<<HTML
<p class="error">Invalid username or password.</p>
HTML;
		}

		return $message . <<<HTML
<form method="post" action="">
	<label for="username">Username: <input type="text" id="username" name="username" /></label>
	<label for="password">Password: <input type="password" id="password" name="password" /></label>
	<input type='submit' value='login' />
</form>
HTML;
	}

	/**
	 *
	 */
	private function handleAdmin() {
		switch($this->request->getUri()->getFilename()) {
			case self::PAGE_LOGIN:
				$this->redirect(self::PAGE_OVERVIEW);
			break;

			case self::PAGE_LOGOUT:
				return $this->handleLogout();
			break;

			case self::PAGE_OVERVIEW:
				return $this->handleOverview();
			break;

			case self::PAGE_SETTINGS:
				return $this->handleSettings();
			break;

			case self::PAGE_SITE:
				return $this->handleSite();
			break;

			default:
				throw new \Exception('Page not found', 404);
			break;
		}
	}

	/**
	 *
	 */
	private function handleLogout() {
		$this->user->logout();
		$this->redirect(self::PAGE_LOGIN);
	}

	/**
	 *
	 */
	private function handleOverview() {
		if(isset($_GET['action']) && isset($_GET['id'])) {
			$id = intval($_GET['id']);

			if($id != 0) {
				switch($_GET['action']) {
					case self::OVERVIEW_RENAME:
						return $this->handleOverviewRename($id);
					break;

					case self::OVERVIEW_DOMAIN:
						return $this->handleOverviewDomain($id);
					break;

					case self::OVERVIEW_ACTIVE:
						return $this->handleOverviewActive($id);
					break;
				}
			}
		}

		return $this->handleOverviewDefaut();
	}

	/**
	 *
	 */
	private function handleOverviewRename($id) {
		$message = '';

		if(isset($_POST['name'])) {
			$this->userPdbc->query('UPDATE `website`
			                        SET `name` =  "' . $this->userPdbc->quote($_POST['name']) . '"
			                        WHERE `id` = "' . $this->userPdbc->quote($id) . '"
			                        AND `uid` = "' . $this->userPdbc->quote($this->user->getID()) . '"');

			if($this->userPdbc->rowCount() > 0) {
				$this->redirect(self::PAGE_OVERVIEW);
			} else {
				$message = <<<HTML
<p class="error">Can't modify name.</p>
HTML;
			}
		}

		$cancel = $this->request->getUri()->getPath() . self::PAGE_OVERVIEW;

		return $message . <<<HTML
<form method="post" action="">
	<label for="name">Name<input type="text" id="name" name="name" /></label>
	<a href="{$cancel}"><input type="button" name="cancel" value="Cancel" /></a>
	<input type='submit' value='submit' />
</form>
HTML;
	}

	/**
	 *
	 */
	private function handleOverviewDomain($id) {
		$message = '';

		if(isset($_POST['domain'])) {
			$this->userPdbc->query('UPDATE `website`
			                        SET `domain` =  "' . $this->userPdbc->quote($_POST['domain']) . '"
			                        WHERE `id` = "' . $this->userPdbc->quote($id) . '"
			                        AND `uid` = "' . $this->userPdbc->quote($this->user->getID()) . '"');

			if($this->userPdbc->rowCount() > 0) {
				$this->redirect(self::PAGE_OVERVIEW);
			} else {
				$message = <<<HTML
<p class="error">Can't modify domain.</p>
HTML;
			}
		}

		$cancel = $this->request->getUri()->getPath() . self::PAGE_OVERVIEW;

		return $message . <<<HTML
<form method="post" action="">
	<label for="domain">Domain<input type="text" id="domain" name="domain" /></label>
	<a href="{$cancel}"><input type="button" name="cancel" value="Cancel" /></a>
	<input type='submit' value='submit' />
</form>
HTML;
	}

	/**
	 *
	 */
	private function handleOverviewActive($id) {
// Als er is gepost aanpassen en redirecten, anders formulier laten zien.
		return 'active';
	}

	/**
	 *
	 */
	private function handleOverviewDefaut() {
		$this->userPdbc->query('SELECT `id`,`name`,`active`
		                        FROM `website`
		                        WHERE `uid` = ' . $this->userPdbc->quote($this->user->getID()));

		$websites = $this->userPdbc->fetchAll();

		if(empty($websites)) {
			return <<<HTML
<p>This user has no websites.</p>
HTML;
		}

		$result = '';

		foreach($websites as $website) {
			$result .= PHP_EOL . <<<HTML
<tr>
	<td><a href="">{$website['name']}</a></td>
	<td><a href="?action=rename&id={$website['id']}"><img src="_media/template/icon-overview-rename.jpg" alt="Overview rename icon" /></a></td>
	<td><a href="?action=domain&id={$website['id']}"><img src="_media/template/icon-overview-domain.jpg" alt="Overview domain icon" /></a></td>
	<td><a href="?action=active&id={$website['id']}"><img src="_media/template/icon-overview-active-{$website['active']}.jpg" alt="Overview active icon" /></a></td>
</tr>
HTML;
		}

		return <<<HTML
<table>
<thead>
<tr>
	<th>Name</th>
	<th>Rename</th>
	<th>Domain</th>
	<th>Active</th>
</tr>
</thead>
<tbody>{$result}
</tbody>
</table>
HTML;
	}

	/**
	 *
	 */
	private function handleSettings() {
		return 'TODO settings';
	}

	/**
	 *
	 */
	private function parseMenuMain() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function handleSite() {
		return 'TODO site';
	}

	/**
	 *
	 */
	private function parseMenuSite() {
		return 'TODO';
	}

	/**
	 *
	 */
	private function redirect($file) {
		throw new \Exception($this->request->getHost() . $this->request->getUri()->getPath() . $file, 301);
	}
}

?>
