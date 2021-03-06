<?php

namespace ViewKeeper;

use UrlMatcher;
use ViewKeeper\Utils\Strings;

/**
 * Class ViewKeeper
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper
 */
class ViewKeeper
{

	/** @var array */
	private $masks = [];

	/**
	 * @param $masks
	 */
	public function __construct($masks)
	{
		$this->masks = $masks;
	}

	/**
	 * @param $mask
	 *
	 * @throw ViewMaskNotFound
	 */
	public function getMask($mask)
	{
		if ($mask === '') {
			throw new ViewMaskNotFound("Mask '{$mask}' not found.");
		}

		$mask = strtolower($mask);
		if(!isset($this->masks[$mask])) {
			throw new ViewMaskNotFound("Mask '{$mask}' not found.");
		}
		return $this->masks[$mask];
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
		if ($mask === '') throw new ViewMaskNotFound("Mask '{$mask}' not found.");
		if ($name === '') throw new InvalidParameter("Invalid parameter name '{$name}'.");

		return $this->parseMask($mask, $name, $view, $suffix);
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
	private function parseMask($mask, $name, $view, $suffix)
	{
		$mask = strtolower($mask);
		if(!isset($this->masks[$mask])) {
			throw new ViewMaskNotFound("Mask '{$mask}' not found.");
		}

		$matcher = new UrlMatcher\Matcher(
			$this->masks[$mask],
			[
				'module' => Strings::strbefore($name, ':'),
				'name' => Strings::strafter($name, ':', $name),
				'view' => $view
			]
		);
		$path = $matcher->parse();

		if($suffix === '' || $suffix != null) {
			$path = $path . '.' . $suffix;
		}
		return $path;
	}
}