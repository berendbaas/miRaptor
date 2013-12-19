<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTMLFormCompact extends HTMLForm {
	public function addInput($title, array $attributes = array()) {
		$this->result .= HTML::openTag('input', $attributes, TRUE) . PHP_EOL;
	}

	public function addTextarea($title, $content = '', array $attributes = array()) {
		$this->result .= HTML::element('textarea', $attributes, $content) . PHP_EOL;
	}

	public function addButton($content = '', array $attributes = array()) {
		$this->result .= HTML::element('button', $attributes, $content) . PHP_EOL;
	}

	public function addSelect($title, array $options = array(), array $attributes = array()) {
		$content = PHP_EOL;

		foreach($options as $optionKey => $optionValue) {
			$content .= HTML::element('option', $optionValue, $optionKey) . PHP_EOL;
		}

		$this->result .= HTML::element('select', $attributes, $content) . PHP_EOL;
	}
}

?>