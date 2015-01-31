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
	public $views = array();

	/**
	 * @param $views
	 */
	public function __construct($views)
	{
		$this->views = $views;
	}

	/**
	 * Return view path of control $name.
	 *
	 * @param $name
	 * @param string $file
	 * @param string $suffix
	 *
	 * @return string
	 */
	public function getControlView($name, $file = 'default', $suffix = 'latte') {
		return $this->views['controls'] . '/' . $name . '/' . $file . '.' . $suffix;
	}
}