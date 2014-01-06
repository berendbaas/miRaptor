<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTMLList {
	private $ordered;
	private $result;

	/**
	 * Construct an HTML list with the given items & order.
	 *
	 * @param boolean $ordered = FALSE
	 * @param array   $attributes = array()
	 */
	public function __construct($ordered = FALSE, $attributes = array()) {
		$this->ordered = $ordered;
		$this->result = HTML::openTag($this->ordered ? 'ol' : 'ul', $attributes);
	}

	/**
	 * Returns the string representation of the HTML List object.
	 *
	 * @return string the string representation of the HTML List object.
	 */
	public function __toString() {
		return $this->result . ($this->ordered ? '</ol>' : '</ul>') . PHP_EOL;
	}

	/**
	 * Add the given item to the HTML list.
	 *
	 * @param  string $item
	 * @param  array  $attributes = array()
	 * @return void
	 */
	public function addItem($item, $attributes = array()) {
		$this->result .= HTML::element('li', $attributes, $item);
	}

	/**
	 * Add the given items to the HTML list.
	 *
	 * @param  array $items
	 * @return void
	 */
	public function addItems(array $items) {
		foreach($items as $item) {
			$this->addItem($item);
		}
	}
}

?>
