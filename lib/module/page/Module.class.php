<?php
namespace lib\module\page;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {
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
				throw new \Exception('get="' . $this->arguments['get']. '" does not exists.');
			break;
		}
	}

	/**
	 *
	 */
	private function parseGet() {
		if(isset($this->arguments['get'])) {
			return $this->arguments['get'];
		}

		throw new \Exception('get="" required.');
	}

	/**
	 *
	 */
	private function parseContent() {
		return isset($this->arguments['name']) ? $this->parseContentName($this->arguments['name'])  : $this->parseContentDefault() ;
	}

	private function parseContentName($name) {
		$this->pdbc->query('SELECT `content`
		                    FROM `module_page_content`
		                    WHERE `pid` = ' . $this->pdbc->quote($this->pageID) . '
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
		                    WHERE `id` = ' .  $this->pdbc->quote($this->pageID));

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
		                    WHERE `id`=' .  $this->pdbc->quote($this->pageID));

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
		if(!isset($this->arguments['name'])) {
			throw new Exception('name="" required.');
		}

		$this->pdbc->query('SELECT `url`
		          FROM `module_page_media`
		          WHERE `pid` = ' . $this->pdbc->quote($this->pageID) . '
		          AND `nid`= (SELECT `id`
		                      FROM `module_page_media_name`
		                      WHERE `name` = "' . $this->pdbc->quote($this->arguments['name']) . '")');

		$media = $this->pdbc->fetch();

		if(!$media) {
			throw new \Exception('Media does not exists.');
		}

		return <<<HTML
<img src="{end($url)}" alt="{$this->arguments['name']}" />
HTML;
	}

	/**
	 *
	 */
	private function parseTitle() {
		$this->pdbc->query('SELECT `name`
		                    FROM `pages`
		                    WHERE `id`=' . $this->pdbc->quote($this->pageID));

		$title = $this->pdbc->fetch();

		if(!$title) {
			throw new \Exception('Title does not exists.');
		}

		return end($title);
	}
}

?>