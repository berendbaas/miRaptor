<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
abstract class AbstractModule implements Runnable {
	const DEFAULT_NAMESPACE = FALSE;
	const DEFAULT_PARSABLE = TRUE;
	const DEFAULT_STATIC = TRUE;

	protected $pdbc;
	protected $url;
	protected $routerID;
	protected $arguments;
	protected $result;

	protected $namespace;
	protected $parsable;
	protected $static;

	/**
	 * Construct an Module object with the given PDBC, URL, pageID & arguments.
	 *
	 * @param \lib\pdbc\PDBC  $pdbc
	 * @param URL             $url
	 * @param int             $pageID
	 * @param array           $arguments
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url, $routerID, Array $arguments) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->routerID = $routerID;
		$this->arguments = $arguments;
		$this->result = '';

		$this->namespace = self::DEFAULT_NAMESPACE;
		$this->parsable = self::DEFAULT_PARSABLE;
		$this->static = self::DEFAULT_STATIC;
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
		return $this->namespace;
	}

	/**
	 * Returns true if the module can be parsed.
	 *
	 * @return boolean true if the module can be parsed.
	 */
	public function isParsable() {
		return $this->parsable;
	}

	/**
	 * Returns true if the module is static.
	 *
	 * @return boolean true if the module is static.
	 */
	public function isStatic() {
		return $this->static;
	}

	public abstract function run();
}

?>