<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTMLTable {
	private $result;

	/**
	 * Construct a new HTML table object.
	 */
	public function __construct() {
		$this->result .= '<table>' . PHP_EOL;
	}

	/**
	 * Returns the string representation of the HTML table object.
	 *
	 * @return string The string representation of the HTML table object.
	 */
	public function __toString() {
		return $this->result . '</table>' . PHP_EOL;
	}

	/**
	 * Add the given header row to the table object.
	 *
	 * @param  array $columns
	 * @return void
	 */
	public function addHeader(array $columns) {
		$this->result .= '<tr>';

		foreach($columns as $column) {
			$this->result .= '<th>' . $column . '</th>';
		}

		$this->result .= '</tr>' . PHP_EOL;
	}

	/**
	 * Add the given row to the table object.
	 *
	 * @param  array $columns
	 * @return void
	 */
	public function addRow(array $columns) {
		$this->result .= '<tr>';

		foreach($row as $columns) {
			$this->result .= '<td>' . $column . '</td>';
		}

		$this->result .= '</tr>' . PHP_EOL;
	}

	/**
	 * Add the given rows to the table object.
	 *
	 * @param  array $rows
	 * @return void 
	 */
	public function addRows(array $rows) {
		foreach($rows as $columns) {
			$this->addRow($columns);
		}
	}

}