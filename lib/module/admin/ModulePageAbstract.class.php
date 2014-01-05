<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
abstract class ModulePageAbstract {
	const DEFAULT_NAMESPACE = FALSE;
	
	const USER_ID = 'user_id';

	protected $pdbc;
	protected $url;
	protected $redirect;
	protected $user;
	protected $result;

	protected $isNamespace;

	/**
	 *
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\util\URL $url, $redirect) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->redirect = $redirect;
		$this->user = new \lib\core\User($pdbc);
		$this->result = '';

		$this->isNamespace = self::DEFAULT_NAMESPACE;
	}

	/**
	 * Returns the string representation of the Module object.
	 *
	 * @return string the string representation of the Module object.
	 */
	public function __toString() {
		return $this->result;
	}

	/**
	 * Returns true if the module uses namespaces.
	 *
	 * @return boolean true if the module uses namespace.
	 */
	public function isNamespace() {
		return $this->isNamespace;
	}

	/**
	 *
	 */
	public abstract function run();
}

?>
