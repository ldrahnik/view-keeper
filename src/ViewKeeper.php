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
		$this->categories = $categories;
	}

	/**
	 * Return view path of control $name.
	 *
	 * @param $name
	 * @param $category
	 * @param string $file
	 * @param string $suffix
	 *
	 * @throw InvalidViewName
	 * @throw ViewCategoryNotFound
	 * @return string
	 */
	public function getView($name, $category, $file = 'default', $suffix = 'latte') {
		if ($category === '') {
			throw new ViewCategoryNotFound("Category '{$name}' not found.");
		}

		if ($name === '') {
			throw new InvalidViewName("Invalid view name '{$name}'.");
		}

		if(isset($this->categories[$category])) {
			return $this->getViewByCategory($name, $category, $file, $suffix);
		}

		throw new ViewCategoryNotFound("Category '{$name}' not found.");
	}

	/**
	 * @param $name
	 * @param $category
	 * @param string $file
	 * @param string $suffix
	 * @return string
	 */
	public function getViewByCategory($name, $category, $file = 'default', $suffix = 'latte') {
		return $this->categories[$category] . '/' . $name . '/' . $file . '.' . $suffix;
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
			$prop = strtolower($name[3]) . substr($name, 4);
			$prop = str_replace("View", "", $prop) . 's';

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