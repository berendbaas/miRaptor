<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTMLForm {
	protected $result;

	/**
	 * Construct an HTML form object with the given method & action.
	 *
	 * @param array $arguments = array('method' => 'post', 'action' => '')
	 */
	public function __construct($arguments = array('method' => 'post', 'action' => '')) {
		$this->result = HTML::openTag('form', $arguments);
	}


	/**
	 * Returns the string representation of the HTML form object.
	 *
	 * @return string the string representation of the HTML form object.
	 */
	public function __toString() {
		return $this->result . '</form>' . PHP_EOL;
	}

	/**
	 * Open a fieldset with the given legend.
	 *
	 * @param  string $legend = '';
	 * @param  array  $attributes = array();
	 * @return void
	 */
	public function openFieldset($legend = '', array $attributes = array()) {
		$this->result .= HTML::openTag('fieldset', $attributes) . PHP_EOL;

		if($legend != '') {
			$this->result .= '<legend>' . $legend . '</legend>' . PHP_EOL;
		}
	}

	/**
	 * Close a fieldset.
	 *
	 * @return void
	 */
	public function closeFieldset() {
		$this->result .= '</fieldset>' . PHP_EOL;
	}

	/**
	 * Add the given content to the current form.
	 *
	 * @param string $content
	 */
	public function addContent($content) {
		$this->result .= $content . PHP_EOL;
	}

	/**
	 * Add a label to the current form.
	 *
	 * @param  string $title
	 * @param  array  $attributes = array()
	 * @return void
	 */
	public function addLabel($title, array $attributes = array()) {
		$this->result .= HTML::element('label', $attributes, $title) . PHP_EOL;
	}

	/**
	 * Add an input field to the current form.
	 *
	 * @param  string $title = ''
	 * @param  array  $attributes = array()
	 * @return void
	 */
	public function addInput($title = '', array $attributes = array()) {
		$this->result .= HTML::openTag('input', $attributes, TRUE) . PHP_EOL;
	}

	/**
	 * Add a textarea to the current form.
	 *
	 * @param  string $title = ''
	 * @param  string $content = ''
	 * @param  array  $attributes = array()
	 * @return void
	 */
	public function addTextarea($title = '', $content = '', array $attributes = array()) {
		$this->result .= HTML::element('textarea', $attributes, $content) . PHP_EOL;
	}

	/**
	 * Add a button to the current form.
	 *
	 * @param  string $content = ''
	 * @param  array  $attributes = array()
	 * @return void
	 */
	public function addButton($content = '', array $attributes = array()) {
		$this->result .= HTML::element('button', $attributes, $content) . PHP_EOL;
	}

	/**
	 * Open a select box.
	 *
	 * @param  string $title = ''
	 * @param  array $attributes = array()
	 * @return void
	 */
	public function openSelect($title = '', array $attributes = array()) {
		$this->result .= HTML::openTag('select', $attributes) . PHP_EOL;
	}

	/**
	 * Close a select box.
	 *
	 * @return void
	 */
	public function closeSelect() {
		$this->result .= '</select>' . PHP_EOL;
	}

	/**
	 * Open a select box optgroup with the given title.
	 *
	 * @param  string  $title
	 * @param  boolean $disabled = FALSE
	 * @return void
	 */
	public function openOptgroup($title, $disabled = FALSE) {
		$this->result .= '<optgroup value="' . $title . '"' . ($disabled !== FALSE) ? '>' : ' disabled="disabled">' . PHP_EOL;
	}

	/**
	 * Close a select box optgroup.
	 *
	 * @return void
	 */
	public function closeOptgroup() {
		$this->result .= '</optgroup' . PHP_EOL;
	}

	/**
	 * Add an option field to the current form.
	 *
	 * @param  string $title
	 * @param  array  $attributes = array()
	 * @return void
	 */
	public function addOption($title, array $attributes = array()) {
		$this->result .= HTML::element('option', $attributes, $title);
	}
}

?>