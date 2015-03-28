<?php

namespace ViewKeeper\Parser;

/**
 * Class ViewKeeperHelperExtension
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\Utils
 */
class Parser {

	/**
	 * Obtain array 'key' => 'value' and string $mask if there are 'key's in $mask method will replace them.
	 *
	 * @param $patterns
	 * @param $mask
	 * @return string
	 */
	public static function replace($patterns, $mask)
	{
		return str_replace(array_keys($patterns), array_values($patterns), $mask);
	}
} 