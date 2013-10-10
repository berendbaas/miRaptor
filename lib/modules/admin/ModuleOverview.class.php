<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleOverview {
	const ACTION_RENAME = 'rename';
	const ACTION_DOMAIN = 'domain';
	const ACTION_ACTIVE = 'active';

	private $pdbc;
	private $url;

	private $userPdbc;
	private $user;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\URL $url, \lib\core\PDBC $userPdbc, \lib\core\User $user) {
		$this->pdbc = $pdbc;
		$this->url = $url;

		$this->userPdbc = $userPdbc;
		$this->user = $user;
	}

	/**
	 *
	 */
	public function get() {
		if(isset($_GET['action']) && isset($_GET['id'])) {
			$id = intval($_GET['id']);

			if($id != 0) {
				switch($_GET['action']) {
					case self::ACTION_RENAME:
						return $this->handleOverviewRename($id);
					break;

					case self::ACTION_DOMAIN:
						return $this->handleOverviewDomain($id);
					break;

					case self::ACTION_ACTIVE:
						return $this->handleOverviewActive($id);
					break;
				}
			}
		}

		return $this->handleOverviewDefault();
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
				throw new \Exception($this->url->getURLBase() . Module::PAGE_OVERVIEW, 301);
			} else {
				$message = <<<HTML
<p class="error">Can't modify name.</p>
HTML;
			}
		}

		$cancel = $this->url->getDirectory() . Module::PAGE_OVERVIEW;

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
				throw new \Exception($this->url->getURLBase() . Module::PAGE_OVERVIEW, 301);
			} else {
				$message = <<<HTML
<p class="error">Can't modify domain.</p>
HTML;
			}
		}

		$cancel = $this->url->getDirectory() . Module::PAGE_OVERVIEW;

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
	private function handleOverviewDefault() {
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
			$site = $this->url->getDirectory() . Module::PAGE_SITE;

			$result .= PHP_EOL . <<<HTML
<tr>
	<td><a href="{$site}?id={$website['id']}">{$website['name']}</a></td>
	<td><a href="?action=rename&amp;id={$website['id']}"><img src="_media/template/icon-overview-rename.jpg" alt="Overview rename icon" /></a></td>
	<td><a href="?action=domain&amp;id={$website['id']}"><img src="_media/template/icon-overview-domain.jpg" alt="Overview domain icon" /></a></td>
	<td><a href="?action=active&amp;id={$website['id']}"><img src="_media/template/icon-overview-active-{$website['active']}.jpg" alt="Overview active icon" /></a></td>
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
}

?>
