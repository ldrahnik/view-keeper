<?php

namespace ViewKeeper\Tests;

use Nette;
use	Tester;
use	Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
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

	function testRegularViewCategoryNotFound()
	{
		Assert::exception(function() {
			$this->keeper->getView('foo', 'bar');
		}, 'ViewKeeper\ViewCategoryNotFound');
	}

	function testInvalidViewName()
	{
		Assert::exception(function() {
			$this->keeper->getView('', 'bar');
		}, 'ViewKeeper\InvalidViewName');
	}
}

$test = new exceptionsTest($container);
$test->run();