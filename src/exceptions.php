<?php

namespace ViewKeeper;

/**
 * Interface Exception
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper
 */
interface Exception
{

}

/**
 * Class ViewCategoryNotFound
 * @package ldrahnik\ViewKeeper
 */
class ViewCategoryNotFound extends \LogicException
{

}

/**
 * Class InvalidParameter
 * @package ldrahnik\ViewKeeper
 */
class InvalidParameter extends \LogicException
{

}

/**
 * Class MemberAccessException
 * @package ldrahnik\ViewKeeper
 */
class MemberAccessException extends \LogicException implements Exception
{
	/**
	 * @param string|object $class
	 * @return MemberAccessException
	 */
	public static function callWithoutName($class)
	{
		$class = is_object($class) ? get_class($class) : $class;

		return new static("Call to class '$class' method without name.");
	}

	/**
	 * @param object|string $class
	 * @param string $method
	 * @return MemberAccessException
	 */
	public static function undefinedMethodCall($class, $method)
	{
		$class = is_object($class) ? get_class($class) : $class;

		return new static("Call to undefined method $class::$method().");
	}
}

