<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTMLFormStacked extends HTMLForm {
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
		$this->addLabel($title, $this->labelAttributes($attributes));
		parent::addInput($title, $attributes);
	}

	public function addTextarea($title, $content = '', array $attributes = array()) {
		$this->addLabel($title, $this->labelAttributes($attributes));
		parent::addTextarea($title, $content, $attributes);
	}

	public function openSelect($title, array $attributes = array()) {
		$this->addLabel($title, $this->labelAttributes($attributes));
		parent::openSelect($title, $attributes);
	}
}

?>