<?php

namespace ViewKeeper\Parser;

/**
 * Class Parser
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\Utils
 */
class Parser {

	/**
	 * Obtain array 'key' => 'value' and string $mask if there are 'key's in $mask method will replace them.
	 *
	 * @param $mask
	 * @param $patterns
	 * @return string
	 */
	public static function replace($mask, $patterns)
	{
		return str_replace(array_keys($patterns), array_values($patterns), $mask);
	}
} 