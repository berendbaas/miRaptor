<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTMLFormAligned extends HTMLForm {
	/**
	 * Returns the attributes of the label tag.
	 *
	 * @param array $attributes
	 * @return array the attributes of the label tag.
	 */
	private function labelAttributes($attributes) {
		$result = array();

		if(isset($attributes['id'])) {
			$result['for'] = $attributes['id'];
		}

		return $result;
	}

	public function addInput($title, array $attributes = array()) {
		$this->result .= '<div>';
		$this->addLabel($title, $this->labelAttributes($attributes));
		$this->result .= HTML::openTag('input', $attributes, TRUE) . '</div>' . PHP_EOL;
	}

	public function addTextarea($title, $content = '', array $attributes = array()) {
		$this->result .= '<div>';
		$this->addLabel($title, $this->labelAttributes($attributes));
		$this->result .= HTML::element('textarea', $attributes, $content) . '</div>' . PHP_EOL;
	}

	public function addButton($content = '', array $attributes = array()) {
		$this->result .= '<div>' . HTML::element('button', $attributes, $content) . '</div>' . PHP_EOL;
	}

	public function addSelect($title, array $options = array(), array $attributes = array()) {
		$content = PHP_EOL;

		foreach($options as $optionKey => $optionValue) {
			$content .= HTML::element('option', $optionValue, $optionKey) . PHP_EOL;
		}

		$this->result .= '<div>';
		$this->addLabel($title, $this->labelAttributes($attributes));
		$this->result .= HTML::element('select', $attributes, $content) . '</div>' . PHP_EOL;
	}
}

?>