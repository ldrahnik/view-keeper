<?php

namespace ViewKeeper;

use ViewKeeper\Parser\Parser;
use ViewKeeper\Utils\Strings;

/**
 * Class ViewKeeper
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper
 */
class ViewKeeper
{

	/**
	 * @var array
	 */
	public $masks = array();

	/**
	 * @param $masks
	 */
	public function __construct($masks)
	{
		foreach($masks as $id => $value) {
			$this->masks[strtolower($id)] = $value;
		}
	}

	/**
	 * Return view path of control $name.
	 *
	 * @param $name
	 * @param $mask
	 * @param string $view
	 * @param string $suffix
	 *
	 * @throw InvalidParameter
	 * @throw ViewMaskNotFound
	 * @return string
	 */
	public function getView($name, $mask, $view = 'default', $suffix = 'latte')
	{
		if ($mask === '') throw new ViewMaskNotFound("Category '{$name}' not found.");
		if ($name === '') throw new InvalidParameter("Invalid parameter name '{$name}'.");
		if ($suffix === '')	throw new InvalidParameter("Invalid parameter suffix '{$suffix}'.");

		$mask = strtolower($mask);
		if(isset($this->masks[$mask])) {
			return $this->getViewByCategory($name, $mask, $view, $suffix);
		}

		throw new ViewMaskNotFound("Mask '{$mask}' not found.");
	}

	/**
	 * Return template $path from mask with forwarded values.
	 *
	 * @param $name
	 * @param $mask
	 * @param string $view
	 * @param string $suffix
	 *
	 * @throw FileNotFound
	 * @return string
	 */
	private function getViewByCategory($name, $mask, $view = 'default', $suffix = 'latte')
	{
		$path = $this->parseViewMask($this->masks[$mask], $name, $view);
		if($suffix != null) {
			$path = $path . '.' . $suffix;
		}
		return $path;
	}

	/**
	 * Return template $path from mask with forwarded values.
	 *
	 * @param $mask
	 * @param $name
	 * @param $view
	 *
	 * @return string
	 */
	private function parseViewMask($mask, $name, $view)
	{
		return Parser::replace(
			[
				'<module>' => Strings::strbefore($name, ':'),
				'<name>' => Strings::strafter($name, ':', $name),
				'<view>' => $view
			],
			$mask);
	}

	/**
	 * Allows the user to access through magic methods to protected and public properties.
	 * There is get<view mask name>('name') for every view.
	 *
	 * @param string $name method name
	 * @param array $args arguments
	 *
	 * @throws MemberAccessException
	 * @return string
	 */
	public function __call($name, $args)
	{
		if (strlen($name) > 3) {

			$op = substr($name, 0, 3);
			$prop = substr($name, 3);
			$prop = strtolower(str_replace("View", "", $prop)) . 's';

			if ($op === 'get' && isset($this->masks[$prop]) & !empty($args)) {
				if(count($args) == 1) {
					return $this->getViewByCategory($args[0], $prop);
				} else if(count($args) == 2) {
					return $this->getViewByCategory($args[0], $prop, $args[1]);
				} else if(count($args) == 3) {
					$suffix = str_replace(".", "", $args[2]);
					return $this->getViewByCategory($args[0], $prop, $args[1], $suffix);
				}
			}
		} else if ($name === '') {
			throw MemberAccessException::callWithoutName($this);
		}

		throw MemberAccessException::undefinedMethodCall($this, $name);
	}
}