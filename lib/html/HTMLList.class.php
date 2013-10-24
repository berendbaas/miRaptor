<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTMLList {
	private $listType;
	private $list;

	/**
	 * Construct an HTML list with the given items & order.
	 *
	 * @param array   $items = array()
	 * @param boolean $ordered = FALSE
	 */
	public function __construct(array $items = array(), $ordered = FALSE) {
		$this->listType = $ordered ? 'ol' : 'ul';
		$this->list = PHP_EOL;

		$this->addItems($items);
	}

	/**
	 * Returns the string representation of the HTML List object.
	 *
	 * @return string the string representation of the HTML List object.
	 */
	public function __toString() {
		return HTML::element($this->listType, array(), $this->list) . PHP_EOL;
	}

	/**
	 * Add the given item at the end of the HTML list.
	 *
	 * @param string $item
	 * @return void
	 */
	public function addItem($item) {
		$this->list .= HTML::element('li', array(), $item) . PHP_EOL;
	}

	/**
	 * Add the given items at the end of the HTML list.
	 *
	 * @param array $items
	 * @return void
	 */
	public function addItems(array $items) {
		foreach($items as $item) {
			$this->addItem($item);
		}
	}
}

?>
