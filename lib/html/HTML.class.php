<?php
namespace lib\html;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class HTML {
	/**
	 * Returns an HTML element with the given tag, attributes & content.
	 *
	 * @param  string $tag
	 * @param  array  $attributes
	 * @parem  string $content
	 * @return string an HTML element with the given tag, attributes & content.
	 */
	public static function element($tag, array $attributes = array(), $content = '') {
		return self::tagOpen($tag, $attributes) . $content . self::tagClose($tag);
	}

	/**
	 * Returns an HTML opening / start tag with the given tag, attributes. You can also make the HTML tag self closing.
	 *
	 * @param  string  $tag
	 * @param  array   $attributes
	 * @param  boolean $closing
	 * @return string  an HTML start tag with the given tag, attributes. You can also make the HTML tag self closing.
	 */
	public static function tagOpen($tag, array $attributes = array(), $closing = FALSE) {
		$result = '<' . $tag;

		foreach($attributes as $key => $value) {
			$result .= ' ' . $key . '="' . $value . '"';
		}

		return $result . ($closing ? ' />' : '>');
	}

	/**
	 * Returns an HTML closing / end tag with the given tag.
	 *
	 * @param  string $tag
	 * @return string an HTML end tag with the given $tag.
	 */
	public static function tagClose($tag) {
		return '</' . $tag . '>';
	}
}

?>
