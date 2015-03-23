<?php

namespace ViewKeeper\Utils;

/**
 * Class ViewKeeperHelperExtension
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\Utils
 */
class Strings {

	/**
	 * Take part of $string after $substring.
	 *
	 * @param $string
	 * @param $substring
	 *
	 * @return string
	 */
	public static function strafter($string, $substring)
	{
		$pos = strpos($string, $substring);
		if ($pos === false)
			return $string;
		else
			return(substr($string, $pos+strlen($substring)));
	}

	/**
	 * Take part of $string before $substring.
	 *
	 * @param $string
	 * @param $substring
	 *
	 * @return string
	 */
	public static function strbefore($string, $substring)
	{
		$pos = strpos($string, $substring);
		if ($pos === false)
			return '';
		else
			return (substr($string, 0, $pos));
	}

	/**
	 * Take part of $string between $start & $end sub strings.
	 *
	 * @param $string
	 * @param $start
	 * @param $end
	 *
	 * @return string
	 */
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
} 