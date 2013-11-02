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
		$name = $this->parseName();
		$group = $this->parseGroup();

		$this->pdbc->query('SELECT `name`, `content`
		                    FROM `module_javascript`
		                    WHERE `name` = "' . $this->pdbc->quote($name) . '"
		                    AND `id_group` ' . ($group == '' ? 'is NULL' : '= (SELECT `id`
		                                      FROM `group`
		                                      WHERE `name` = "' . $this->pdbc->quote($group) . '")'));

		$javascript = $this->pdbc->fetch();

		$this->result = <<<HTML
<script>
/* {$javascript['name']} start */
{$javascript['content']}
/* {$javascript['name']} end */
</script>
HTML;
	}

	/**
	 * Returns the group argument, if one is given.
	 *
	 * @return string                        the group argument, if one is given.
	 * @throws /lib/core/StatusCodeException if none is given.
	 */
	private function parseGroup() {
		if(isset($this->arguments['group'])) {
			return $this->arguments['group'];
		}

		return '';
	}

	/**
	 * Returns the name argument, if one is given.
	 *
	 * @return string                        the name argument, if one is given.
	 * @throws /lib/core/StatusCodeException if none is given.
	 */
	private function parseName() {
		if(isset($this->arguments['name'])) {
			return $this->arguments['name'];
		}

		throw new \Exception('name="" required.');
	}
}

?>