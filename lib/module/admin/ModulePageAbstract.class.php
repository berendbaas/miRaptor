<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
abstract class ModulePageAbstract {
	const GET_CONTENT = 'content';
	const GET_LOGBOX = 'logbox';
	const GET_MENU = 'menu';

	protected $pdbc;
	protected $url;
	protected $arguments;
	protected $user;

	/**
	 *
	 */
	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, array $arguments, \lib\core\User $user) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->arguments = $arguments;
		$this->user = $user;
	}

	/**
	 *
	 */
	public function get() {
		if(!isset($this->arguments['get'])) {
			throw new \Exception('Get="" required.');
		}

		switch($this->arguments['get']) {
			case self::GET_CONTENT:
				return $this->content();
			break;

			case self::GET_LOGBOX:
				return $this->logBox();
			break;

			case self::GET_MENU:
				return $this->menu();
			break;

			default:
				throw new \Exception('Get="' . $this->arguments['get'] . '" not supported.');
			break;
		}
	}

	/**
	 *
	 */
	public function hasAccess($id) {
		$this->pdbc->query('SELECT `name`
		                    FROM `website`
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		return $this->pdbc->fetch() != array();
	}

	/**
	 *
	 */
	public abstract function content();

	/**
	 *
	 */
	public abstract function logBox();

	/**
	 *
	 */
	public abstract function menu();
}

?>
