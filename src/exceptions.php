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
class ViewMaskNotFound extends \LogicException
{

}

/**
 * Class InvalidParameter
 * @package ldrahnik\ViewKeeper
 */
class InvalidParameter extends \LogicException
{

}

