<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTML {
	public static function tagStart($tag, array() $attributes) {
		$result = '<' . $tag;

		foreach($attributs as $key => $value) {
			$result .= ' ' . $key . '="' . $value . '"';
		}

		return $result . '>';
	}

	public static function tagEnd($tag) {
		return '</' . $tag . '>';
	}
}

?>
