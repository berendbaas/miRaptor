<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModuleHandleOverview extends ModuleHandleAbstract {
	const ACTION_RENAME = 'rename';
	const ACTION_DOMAIN = 'domain';
	const ACTION_ACTIVE = 'active';

	public function content() {
		if(isset($_GET['action']) && isset($_GET['id'])) {
			$id = intval($_GET['id']);

			if($id != 0) {
				switch($_GET['action']) {
					case self::ACTION_RENAME:
						return $this->rename($id);
					break;

					case self::ACTION_DOMAIN:
						return $this->domain($id);
					break;

					case self::ACTION_ACTIVE:
						return $this->active($id);
					break;
				}
			}
		}

		return $this->main();
	}

	/**
	 *
	 */
	private function rename($id) {
		$message = '';

		if(isset($_POST['name'])) {
			$message = $this->renamePost();
		}

		return $this->renameGet($message);
	}

	/**
	 *
	 */
	private function renamePost() {
		$this->pdbc->query('UPDATE `website`
		                    SET `name` =  "' . $this->pdbc->quote($_POST['name']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		if($this->pdbc->rowCount() > 0) {
			throw new \Exception($this->url->getURLPath(), 301);
		}

		return <<<HTML
<p class="error">Can't modify name.</p>
HTML;
	}

	/**
	 *
	 */
	private function renameGet($message = '') {
		$cancel = $this->url->getDirectory() . Module::PAGE_OVERVIEW;

		return <<<HTML
<h2>Edit website name</h2>
{$message}
<form method="post" action="">
	<div><label for="name">Name</label><input type="text" name="name" placeholder="Name" /></div>
	<div><a href="{$cancel}"><button type="button">Cancel</button></a><button type="submit" />Submit</button></div>
</form>
HTML;
	}

	/**
	 *
	 */
	private function domain($id) {
		$message = '';

		if(isset($_POST['domain'])) {
			$this->pdbc->query('UPDATE `website`
			                    SET `domain` =  "' . $this->pdbc->quote($_POST['domain']) . '"
			                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
			                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

			if($this->pdbc->rowCount() > 0) {
				throw new \Exception($this->url->getURLPath(), 301);
			} else {
				$message = <<<HTML
<p class="error">Can't modify domain.</p>
HTML;
			}
		}

		$cancel = $this->url->getDirectory() . Module::PAGE_OVERVIEW;

		return <<<HTML
<h2>Edit domain</h2>
{$message}
<form method="post" action="">
	<div><label for="domain">Domain</label><input type="text" name="domain" placeholder="Domain" /></div>
	<div><a href="{$cancel}"><button type="button">Cancel</button></a><button type="submit" />Submit</button></div>
</form>
HTML;
	}

	/**
	 *
	 */
	private function active($id) {
		/* $this->pdbc->query('UPDATE `website`
		                    SET `domain` =  "' . $this->pdbc->quote($_POST['domain']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		
		*/
		throw new \Exception($this->url->getURLPath(), 301);
	}

	/**
	 *
	 */
	private function main() {
		$this->pdbc->query('SELECT `id`,`name`,`active`
		                    FROM `website`
		                    WHERE `uid` = ' . $this->pdbc->quote($this->user->getID()));

		$websites = $this->pdbc->fetchAll();

		if(!$websites) {
			return <<<HTML
<p>No websites.</p>
HTML;
		}

		$result = '';

		foreach($websites as $website) {
			$site = $this->url->getDirectory() . Module::PAGE_SITE;

			$result .= PHP_EOL . <<<HTML
<tr>
	<td><a href="{$site}?id={$website['id']}">{$website['name']}</a></td>
	<td><a class="rename" href="?id={$website['id']}&amp;action=rename"></a></td>
	<td><a class="domain" href="?id={$website['id']}&amp;action=domain"></a></td>
	<td><a class="active-{$website['active']}" href="?id={$website['id']}&amp;action=active"></a></td>
</tr>
HTML;
		}

		return <<<HTML
<h2>Overview</h2>
<table>
<thead>
<tr>
	<th>Website</th>
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

	public function logBox() {
		$logout = $this->url->getDirectory() . Module::PAGE_LOGOUT;

		return <<<HTML
<ul>
	<li><a href="{$logout}">Logout</a></li>
</ul>
HTML;
	}

	public function menu() {
		$overview = $this->url->getDirectory() . Module::PAGE_OVERVIEW;
		$settings = $this->url->getDirectory() . Module::PAGE_SETTINGS;

		return <<<HTML
<h2>Menu</h2>
<ul>
	<li><a href="{$overview}">Overview</a></li>
	<li><a href="{$settings}">Settings</a></li>
</ul>
HTML;
	}
}

?>
