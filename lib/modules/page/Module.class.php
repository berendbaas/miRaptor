<?php
namespace lib\modules\page;

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
		switch($this->parseGet()) {
			case "content":
				$this->result = $this->parseContent();
			break;
			case "description":
				$this->result = $this->parseDescription();
			break;
			case "media":
				$this->result = $this->parseMedia();
			break;
			case "title":
				$this->result = $this->parseTitle();
			break;
			default:
				throw new \Exception('get="' . $this->args['get']. '" does not exists.');
			break;
		}
	}

	/**
	 *
	 */
	private function parseGet() {
		if(isset($this->args['get'])) {
			return $this->args['get'];
		}

		throw new \Exception('get="" required.');
	}

	/**
	 *
	 */
	private function parseContent() {
		return isset($this->args['name']) ? $this->parseContentName($this->args['name'])  : $this->parseContentDefault() ;
	}

	private function parseContentName($name) {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_page_content`
		                    WHERE `pid` = ' . $this->pdbc->quote($this->page) . '
		                    AND `nid`= (SELECT `id`
		                                FROM `module_page_content_name`
		                                WHERE `name` = "' . $this->pdbc->quote($name) . '")');

		$content = $this->pdbc->fetch();

		if(!$content) {
			throw new \Exception('Content does not exists.');
		}

		return end($content);
	}

	private function parseContentDefault() {
		$this->pdbc->query('SELECT `content`
		                    FROM `pages`
		                    WHERE `id` = ' .  $this->pdbc->quote($this->page));

		$content = $this->pdbc->fetch();

		if(!$content) {
			throw new \Exception('Content does not exists.');
		}

		return end($content);
	}

	/**
	 *
	 */
	private function parseDescription() {
		$this->pdbc->query('SELECT `description`
		                    FROM `pages`
		                    WHERE `id`=' .  $this->pdbc->quote($this->page));

		$description = $this->pdbc->fetch();

		if(!$description) {
			throw new \Exception('Description does not exists.');
		}

		return end($description);
	}

	/**
	 *
	 */
	private function parseMedia() {
		if(!isset($this->args['name'])) {
			throw new Exception('name="" required.');
		}

		$this->pdbc->query('SELECT `url`
		          FROM `module_page_media`
		          WHERE `pid` = ' . $this->pdbc->quote($this->page) . '
		          AND `nid`= (SELECT `id`
		                      FROM `module_page_media_name`
		                      WHERE `name` = "' . $this->pdbc->quote($this->args['name']) . '")');

		$media = $this->pdbc->fetch();

		if(!$media) {
			throw new \Exception('Media does not exists.');
		}

		return <<<HTML
<img src="{end($url)}" alt="{$this->args['name']}" />
HTML;
	}

	/**
	 *
	 */
	private function parseTitle() {
		$this->pdbc->query('SELECT `name`
		                    FROM `pages`
		                    WHERE `id`=' . $this->pdbc->quote($this->page));

		$title = $this->pdbc->fetch();

		if(!$title) {
			throw new \Exception('Title does not exists.');
		}

		return end($title);
	}
}

?>