<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
abstract class ModuleHandleAbstract {
	const GET_CONTENT = 'content';
	const GET_LOGBOX = 'logbox';
	const GET_MENU = 'menu';

	protected $pdbc;
	protected $url;
	protected $args;
	protected $user;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\URL $url, array $args, \lib\core\User $user) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->args = $args;
		$this->user = $user;
	}

	/**
	 *
	 */
	public function get() {
		if(isset($this->args['get'])) {
			switch($this->args['get']) {
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
					throw new \Exception('Get="" not supported.');
				break;
			}
		}

		throw new \Exception('Get="" must be given.');
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
