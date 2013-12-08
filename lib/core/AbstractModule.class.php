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
	const DEFAULT_PARSABLE = FALSE;
	const DEFAULT_STATIC = FALSE;

	protected $pdbc;
	protected $url;
	protected $routerID;
	protected $arguments;
	protected $result;

	protected $isNamespace;
	protected $isParsable;
	protected $isStatic;

	/**
	 * Construct a Module object with the given PDBC, URL, pageID & arguments.
	 *
	 * @param \lib\pdbc\PDBC  $pdbc
	 * @param URL             $url
	 * @param int             $pageID
	 * @param array           $arguments
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, URL $url, $routerID, array $arguments) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->routerID = $routerID;
		$this->arguments = $arguments;
		$this->result = '';

		$this->isNamespace = self::DEFAULT_NAMESPACE;
		$this->isParsable = self::DEFAULT_PARSABLE;
		$this->isStatic = self::DEFAULT_STATIC;
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
	 * Returns true if the module can be parsed.
	 *
	 * @return boolean true if the module can be parsed.
	 */
	public function isParsable() {
		return $this->isParsable;
	}

	/**
	 * Returns true if the module is static.
	 *
	 * @return boolean true if the module is static.
	 */
	public function isStatic() {
		return $this->isStatic;
	}

	public abstract function run();
}

?>