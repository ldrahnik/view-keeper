<?php

namespace ViewKeeper;

/**
 * View Keeper.
 *
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 * @package view-keeper
 */
class ViewKeeper
{

	/**
	 * @var array
	 */
	public $categories = array();

	/**
	 * @param $categories
	 */
	public function __construct($categories)
	{
		foreach($categories as $id => $value) {
			$this->categories[strtolower($id)] = $value;
		}
	}

	/**
	 * Return view path of control $name.
	 *
	 * @param $name
	 * @param $category
	 * @param string $view
	 * @param string $suffix
	 *
	 * @throw InvalidParameter
	 * @throw ViewCategoryNotFound
	 * @return string
	 */
	public function getView($name, $category, $view = 'default', $suffix = 'latte')
	{
		if ($category === '') throw new ViewCategoryNotFound("Category '{$name}' not found.");
		if ($name === '') throw new InvalidParameter("Invalid parameter name '{$name}'.");
		if ($suffix === '')	throw new InvalidParameter("Invalid parameter name '{$suffix}'.");

		$category = strtolower($category);
		if(isset($this->categories[$category])) {
			return $this->getViewByCategory($name, $category, $view, $suffix);
		}

		throw new ViewCategoryNotFound("Category '{$category}' not found.");
	}

	/**
	 * Return $path from mask with forwarded values.
	 *
	 * @param $name
	 * @param $category
	 * @param string $view
	 * @param string $suffix
	 *
	 * @return string
	 */
	private function getViewByCategory($name, $category, $view = 'default', $suffix = 'latte')
	{
		return $this->parseViewMask($this->categories[$category], $name, $category, $view) . '.' . $suffix;
	}
	
	private function parseViewMask($mask, $name, $category, $view)
	{
		$patterns = array(
			'<name>' => $name,
			'<category>' => $category,
			'<view>' => $view
		);
		$path = str_replace(array_keys($patterns), array_values($patterns), $mask);
		return $path;
	}

	/**
	 * Allows the user to access through magic methods to protected and public properties.
	 * There is get<view category>('name') for every view.
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

			if ($op === 'get' && isset($this->categories[$prop]) & !empty($args)) {
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