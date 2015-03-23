<?php

namespace ViewKeeper;

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
	public $categories = array();

	/**
	 * @var bool
	 */
	private $fileCheck = false;

	/**
	 * @var bool
	 */
	private $lastFileCheck = false;

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
		if ($suffix === '')	throw new InvalidParameter("Invalid parameter suffix '{$suffix}'.");

		$category = strtolower($category);
		if(isset($this->categories[$category])) {
			return $this->getViewByCategory($name, $category, $view, $suffix);
		}

		throw new ViewCategoryNotFound("Category '{$category}' not found.");
	}

	/**
	 * Return template $path from mask with forwarded values.
	 *
	 * @param $name
	 * @param $category
	 * @param string $view
	 * @param string $suffix
	 *
	 * @throw FileNotFound
	 * @return string
	 */
	private function getViewByCategory($name, $category, $view = 'default', $suffix = 'latte')
	{
		$path = $this->parseViewMask($this->categories[$category], $name, $category, $view);
		if($suffix != null) {
			$path = $path . '.' . $suffix;
		}
		if($this->fileCheck == true && !file_exists($path)) {
			throw new FileNotFound("File '{$path}' not found.");
		}
		if($this->lastFileCheck == true) {
			$this->fileCheck = false;
		}
		return $path;
	}

	/**
	 * Return template $path from mask with forwarded values.
	 *
	 * @param $mask
	 * @param $name
	 * @param $category
	 * @param $view
	 *
	 * @return string
	 */
	private function parseViewMask($mask, $name, $category, $view)
	{
		$patterns = array(
			'<module>' => $this->getModuleName($name),
			'<name>' => $this->getPresenterName($name),
			'<category>' => $category,
			'<view>' => $this->getViewName($view)
		);

		return str_replace(array_keys($patterns), array_values($patterns), $mask);
	}

	/**
	 * Get View name
	 *
	 * @param $name
	 * @return string <view> or ''
	 */
	private function getViewName($name)
	{
		if($name == null) {
			return '';
		}
		return $name;
	}

	/**
	 * Separate Presenter from Module
	 *
	 * @param $name
	 * @return string <presenter> or ''
	 */
	private function getPresenterName($name)
	{
		return Strings::strafter($name, ':');
	}

	/**
	 * Separate Module from Presenter
	 *
	 * @param $name
	 * @return string <module> or NULL
	 */
	private function getModuleName($name)
	{
		return Strings::strbefore($name, ':');
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

	/**
	 * Setter of $fileCheck
	 *
	 * @param bool $state
	 *
	 * @return $this
	 */
	public function setFileCheck($state = true)
	{
		if($state) {
			$this->fileCheck = true;
		} else {
			$this->fileCheck = false;
			$this->lastFileCheck = false;
		}
		return $this;
	}

	/**
	 * Getter of $fileCheck
	 *
	 * @return bool
	 */
	public function getFileCheck()
	{
		return $this->fileCheck;
	}

	/**
	 * Setter of $lastFileCheck
	 *
	 * @param bool $state
	 *
	 * @return $this
	 */
	public function setLastFileCheck($state = true)
	{
		if($state) {
			$this->fileCheck = true;
			$this->lastFileCheck = true;
		} else {
			$this->lastFileCheck = false;
		}
		return $this;
	}

	/**
	 * Getter of $lastFileCheck
	 *
	 * @return bool
	 */
	public function getLastFileCheck()
	{
		return $this->lastFileCheck;
	}
}