<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
abstract class HTMLForm {
	private $method;
	private $action;
	private $fieldset;
	private $result;

	/**
	 * Construct an HTML form object with the given method & action.
	 *
	 * @param string $method = 'post'
	 * @param string $action = ''
	 */
	public function __construct($method = 'post', $action = '') {
		$this->method = $method;
		$this->action = $action;
		$this->fieldset = FALSE;
		$this->result = '';
	}

	/**
	 * Returns the string representation of the HTML form object.
	 *
	 * @return string the string representation of the HTML form object.
	 */
	public function __toString() {
		return HTML::element('form', array('action' => $this->action, 'method' => $this->method), $this->result);
	}

	/**
	 * Returns true if the button, input, textarea and so on will be added in a fieldset.
	 *
	 * @return boolean true if the button, input, textarea and so on will be added in a fieldset.
	 */
	public function isFieldset() {
		return $this->fieldset;
	}

	/**
	 * Open a fieldset if none are open.
	 *
	 * @param  string $legend = '';
	 * @return void
	 */
	public function fieldsetOpen($legend = '') {
		if(!$this->fieldset) {
			$this->result .= HTML::tagOpen('fieldset') . PHP_EOL;

			if($legend != '') {
				$this->result .= HTML::element('legend', array(), $legend) . PHP_EOL;
			}

			$this->fieldset = TRUE;
		}
	}

	/**
	 * Close the fieldset if one is open.
	 *
	 * @return void
	 */
	public function fieldsetClose() {
		if($this->fieldset) {
			$this->result .= HTML::tagClose('fieldset') . PHP_EOL;
		}
	}

	/**
	 * Add a button to the current form.
	 *
	 * @param
	 * @return void
	 */
	public abstract function button($content, $attributes = array(), $type = 'button');

	/**
	 * Add an input field to the current form.
	 *
	 * @param
	 * @return void
	 */
	public abstract function input($content, $attributes = array());

	/**
	 * Add a textarea to the current form.
	 *
	 * @param
	 * @return void
	 */
	public abstract function textarea($content, $attributes = array());
}

?>
