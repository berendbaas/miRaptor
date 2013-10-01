<?php
namespace lib\modules\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module implements \lib\core\ModuleInterface {
	private $pdbc;
	private $request;
	private $page;
	private $args;
	private $result;
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
		$this->user = new \lib\core\User(new \lib\core\Mysql($config['mysql']));
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
		switch($this->request->getUri()->getFilename()) {
			case '':
				$this->result = 'home';
			break;
			case 'login':
				$this->result = 'login';
			break;
			case 'logout':
				$this->result = 'logout';
			break;
			case 'overview':
				$this->result = 'overview';
			break;
			case 'site':
				$this->result = 'site';
			break;
			case 'settings':
				$this->result = 'settings';
			break;
			default:
				$this->result = 'default';
			break;
		}
	}
}

?>
