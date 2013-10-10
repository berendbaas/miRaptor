<?php
namespace lib\modules\stylesheet;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module implements \lib\core\ModuleInterface {
	private $pdbc;
	private $url;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(\lib\core\PDBC $pdbc, \lib\core\URL $url, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->url = $url;
		$this->page = $page;
		$this->args = $args;
		$this->result = '';
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
		return TRUE;
	}

	/**
	 *
	 */
	public function isNamespace() {
		return FALSE;
	}

	/**
	 *
	 */
	public function run() {
		$this->pdbc->query('SELECT `name`, `content`
		                    FROM `module_stylesheet`
		                    RIGHT JOIN (SELECT `sid`,`order`
		                                FROM `module_stylesheet_template`
		                                WHERE `tid` = (SELECT `tid`
		                                               FROM `pages`
		                                               WHERE `id` = "' . $this->pdbc->quote($this->page) . '")) AS `stylesheets`
		                    ON `module_stylesheet`.`id` = `stylesheets`.`sid`
		                    ORDER BY `order` ASC');

		$stylesheets = $this->pdbc->fetchAll();

		foreach($stylesheets as $stylesheet) {
			$this->result .= PHP_EOL . <<<HTML
/* {$stylesheet['name']} start */
{$stylesheet['content']}
/* {$stylesheet['name']} end */
HTML;
		}

		$this->result = <<<HTML
<style>{$this->result}
</style>
HTML;
	}
}

?>