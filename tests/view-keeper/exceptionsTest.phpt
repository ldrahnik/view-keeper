<?php

namespace ViewKeeper\Tests;

use	Tester;
use	Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

/**
 * Class exceptionTest
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\Tests
 *
 * @testCase
 */
class exceptionsTest extends Tester\TestCase
{
	/** @var \ViewKeeper\ViewKeeper */
	private $keeper;

	/** @var /Container */
	private $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	protected function setUp()
	{
		$this->keeper = $this->container->getService('keeper.ViewKeeper');
	}

	function testRegularViewMaskNotFound()
	{
		Assert::exception(function() {
			$this->keeper->getView('foo', 'bar');
		}, 'ViewKeeper\ViewMaskNotFound');
	}

	function testInvalidParameter()
	{
		Assert::exception(function() {
			$this->keeper->getView('', 'bar');
		}, 'ViewKeeper\InvalidParameter');
	}
}

$test = new exceptionsTest($container);
$test->run();
