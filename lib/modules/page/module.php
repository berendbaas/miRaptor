<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Page implements ModuleInterface {
	private $pdbc;
	private $page;
	private $args;
	private $result;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, $page, array $args) {
		$this->pdbc = $pdbc;
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
				throw new Exception('get="' . $this->args['get']. '" does not exists.');
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

		throw new Exception('get="" required.');
	}

	/**
	 *
	 */
	private function parseContent() {
		return isset($this->args['name']) ? $this->parseContentName($this->args['name'])  : $this->parseContentNoName() ;
	}

	private function parseContentName($name) {
		$query = '(SELECT `tid`
		           FROM `pages`
		           WHERE `id` = "' . $this->pdbc->quote($this->page) . '")'; // Get template ID

		$query = '(SELECT `id`
		           FROM `module_page_content_name`
		           WHERE `tid` = ' . $query . ' AND `name` = "' . $this->pdbc->quote($name) . '")'; // Get name ID

		$query = 'SELECT `content`
		          FROM `module_page_content`
		          WHERE `pid` = ' . $this->pdbc->quote($this->page) . ' AND `nid`= ' . $query; // Get content url

		$content = $this->pdbc->fetch($query);

		if(empty($content)) {
			throw new Exception('Content does not exists.');
		}

		return end(end($content));
	}

	private function parseContentNoName() {
		$result = $this->pdbc->fetch('SELECT `content`
		                              FROM `pages`
		                              WHERE `id`=' .  $this->pdbc->quote($this->page));

		if(empty($result)) {
			throw new Exception('Content does not exists.');
		}

		return end(end($result));
	}

	/**
	 *
	 */
	private function parseDescription() {
		$result = $this->pdbc->fetch('SELECT `description`
		                              FROM `pages`
		                              WHERE `id`=' .  $this->pdbc->quote($this->page));

		if(empty($result)) {
			throw new Exception('Description does not exists.');
		}

		return end(end($result));
	}

	/**
	 *
	 */
	private function parseMedia() {
		if(!isset($this->args['type'])) {
			throw new Exception('type="" required.');
		}

		if(!isset($this->args['name'])) {
			throw new Exception('name="" required.');
		}

		$query = '(SELECT `tid`
		           FROM `pages`
			   WHERE `id` = ' . $this->pdbc->quote($this->page) . ')'; // Get template ID

		$query = '(SELECT `id`
		           FROM `module_page_media_name`
		           WHERE `tid` = ' . $query . ' AND `name` = "' . $this->pdbc->quote($this->args['name']) . '")'; // Get name ID

		$query = 'SELECT `url`
		          FROM `module_page_media`
		          WHERE `pid` = ' . $this->pdbc->quote($this->page) . ' AND `nid`= ' . $query; // Get media url

		$url = $this->pdbc->fetch($query);

		if(empty($url)) {
			throw new Exception('Media does not exists.');
		}

		return '<!--{media type="' . $this->args['type'] . '" name="' . $this->args['name'] . '" url="' . end(end($url)) . '"}-->';
	}

	/**
	 *
	 */
	private function parseTitle() {
		$result = $this->pdbc->fetch('SELECT `name`
		                              FROM `pages`
		                              WHERE `id`=' . $this->pdbc->quote($this->page));

		if(empty($result)) {
			throw new Exception('Title does not exists.');
		}

		return end(end($result));
	}
}

?>