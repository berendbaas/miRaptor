<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Website {
	private $pdbc;
	private $user;
	private $website;

	/**
	 * Construct a Website object with the given, pdbc, user & website id.
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, User $user, $websiteID) {
		$this->pdbc = $pdbc;
		$this->user = $user;
		
		$this->pdbc->query('SELECT `id`, `name`, `directory`, `domain`, `active`
		                    FROM `website`
		                    WHERE `id` = "' . $this->pdbc->quote($websiteID) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		$this->website = $this->pdbc->fetch();
	}

	/**
	 * Returns true if the user has access to modify the website.
	 *
	 * @return boolean true if the user has access to modify the website.
	 */
	public function hasAccess() {
		return $this->website !== NULL;
	}

	/**
	 * Returns the website ID.
	 *
	 * @return int the website ID.
	 */
	public function getID() {
		return isset($this->website['id']) ? $this->website['id'] : NULL;
	}

	/**
	 * Returns the website name.
	 *
	 * @return string the website name.
	 */
	public function getName() {
		return isset($this->website['name']) ? $this->website['name'] : NULL;
	}

	/**
	 * Returns the website folder.
	 *
	 * @return string the website folder.
	 */
	public function getDirectory() {
		return isset($this->website['directory']) ? $this->website['directory'] : NULL;
	}

	/**
	 * Returns the website domain.
	 *
	 * @return string the website domain.
	 */
	public function getDomain() {
		return isset($this->website['domain']) ? $this->website['domain'] : NULL;
	}

	/**
	 * Returns the website active.
	 *
	 * @return int the website active.
	 */
	public function getActive() {
		return isset($this->website['active']) ? $this->website['active'] : NULL;
	}
}

?>
