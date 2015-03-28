<?php

namespace ViewKeeper\Utils;

/**
 * Class Arrays
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\Utils
 */
class Arrays {

	/**
	 * @param $arr
	 * @return array
	 */
	public static function array_strlower($arr) {
		$arr_strlower = [];
		foreach($arr as $id => $value) {
			$arr_strlower[strtolower($id)] = $value;
		}
		return $arr_strlower;
	}
}