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

	/**
	 * Add the given row to the form and wrap it in a HTML div element.
	 *
	 * @param string $row
	 * @return void
	 */
	private function addRow($row) {
		$this->result .= '<div>' . $row . '</div>' . PHP_EOL;
	}

	public function addInput($title, array $attributes = array()) {
		$this->addRow($this->addLabel($title, $this->labelAttributes($attributes)) .
		              HTML::openTag('input', $attributes, TRUE) . PHP_EOL);
	}

	public function addTextarea($title, $content = '', array $attributes = array()) {
		$this->addRow($this->addLabel($title, $this->labelAttributes($attributes)) .
		              HTML::element('textarea', $attributes, $content) . PHP_EOL);
	}

	public function addButton($content = '', array $attributes = array()) {
		$this->addRow(HTML::element('button', $attributes, $content) . PHP_EOL);
	}

	public function addSelect($title, array $options = array(), array $attributes = array()) {
		$content = PHP_EOL;

		foreach($options as $optionKey => $optionValue) {
			if(is_int($optionKey)) {
				$content .= HTML::element('option', array(), $optionValue) . PHP_EOL;
			} else {
				$content .= HTML::element('option', $optionValue, $optionKey) . PHP_EOL;
			}
		}

		$this->addRow($this->addLabel($title, $this->labelAttributes($attributes)) .
		              HTML::element('select', $attributes, $content) . PHP_EOL);
	}
}

?>