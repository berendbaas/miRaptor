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
	 * Open a row.
	 *
	 * @return void
	 */
	public function openRow() {
		$this->result .= '<tr>';
	}

	/**
	 * Close a row.
	 *
	 * @return void
	 */
	public function closeRow() {
		$this->result .= '</tr>' . PHP_EOL;
	}

	/**
	 * Add the given header row to the table object.
	 *
	 * @param  array $row
	 * @return void
	 */
	public function addHeaderRow(array $row) {
		$this->openRow();

		foreach($row as $column) {
			$this->addHeaderCollumn($column);
		}

		$this->closeRow();
	}

	/**
	 * Add the given header collumn to the table object.
	 *
	 * @param  string $column
	 * @return void
	 */
	public function addHeaderCollumn($column) {
		$this->result .= '<th>' . $column . '</th>';
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

	/**
	 * Add the given row to the table object.
	 *
	 * @param  array $row
	 * @return void
	 */
	public function addRow(array $row) {
		$this->openRow();

		foreach($row as $column) {
			$this->addColumn($column);
		}

		$this->closeRow();
	}

	/**
	 * Add the given column to the table object.
	 *
	 * @param  string 
	 * @return void
	 */
	public function addColumn($column) {
		$this->result .= '<td>' . $column . '</td>';
	}
}