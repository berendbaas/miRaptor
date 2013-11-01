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
	 * Construct a new HTML table
	 */
	public function __construct() {
		$this->result .= '<table>';
	}

	/**
	 * returns the string representation of the HTML table object.
	 * @return string The string representation of the HTML table object.
	 */
	public function __toString() {
		$this->result .= '</table>';
		return $this->result;
	}

	/**
	 * Adds an row of header columns to the table
	 * @param array $columns [description]
	 * @return void 
	 */
	public function addHeader(array $columns) {
		$this->result .= '<tr>';
		foreach ($columns as $column) {
			$this->result .= "<th>" . $column . "</th>";
		}
		$this->result .= '</tr>';
	}

	/**
	 * Add a row to the table
	 * @param array $row row of columns
	 * @return void
	 */
	public function addRow(array $row) {
		$this->result .= '<tr>';
		foreach ($row as $columns) {
			$this->result .= '<td>' . $column . '</td>';
		}
		$this->result .= '</tr>';
	}

	/**
	 * Add rows to the current table
	 * @param array $rows array of arrays containing the fields
	 * @return void 
	 */
	public function addRows(array $rows) {
		foreach ($rows as $row) {
			$this->addRow($row);
		}
	}

}