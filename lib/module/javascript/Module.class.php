<?php
namespace lib\module\javascript;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Module extends \lib\core\AbstractModule {

	public function run() {
		$this->pdbc->query('SELECT `name`, `content`
							FROM `module_javascript`
							WHERE `id` = '. $this->parseID());
		$javascript = $this->pdbc->fetch();

		$this->result = <<<HTML
<script>
/* {$javascript['name']} start */
{$javascript['content']}
/* {$javascript['name']} end*/
</script>
HTML;
	}

	private function parseID() {
		if (isset($this->arguments['id']) && ($id = intval($this->arguments['id'])) != 0) {
			return $id;
		}

		throw new \Exception('get="" is required for javascript module');
	}
}

?>