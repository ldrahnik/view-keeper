<?php

namespace ViewKeeper\Tests;

use	Tester;
use	Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

/**
 * Class ViewKeeperTest
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\Tests
 *
 * @testCase
 */
class ViewKeeperTest extends Tester\TestCase
{
	/** @var \ViewKeeper\ViewKeeper */
	private $keeper;

	/** @var /Container */
	private $container;

	private $name = "ViewKeeperRest";
	private $nameWithModule = "Backend:Homepage";

	public function __construct($container)
	{
		$this->container = $container;
	}

	protected function setUp()
	{
		$this->keeper = $this->container->getService('keeper.ViewKeeper');
	}

	function testServiceConfiguration()
	{
		Assert::type('ViewKeeper\ViewKeeper', $this->keeper);
	}

	function testGetView()
	{
		Assert::match('test/controls/' . $this->name . '/default.latte', $this->keeper->getView($this->name, 'controls'));
		Assert::match('test/presenters/' . $this->name . '/default.latte', $this->keeper->getView($this->name, 'presenters'));
		Assert::match('test/@layout.latte', $this->keeper->getView($this->name, 'layouts', 'layout'));
	}

	function testCaseInsensitive()
	{
		Assert::match('test/caseinsensitives/' . $this->name . '/default.latte', $this->keeper->getView($this->name, 'CaseInSensitives'));
	}

	function testModule()
	{
		Assert::match('test/BackendModule/presenters/Homepage/default.latte', $this->keeper->getView($this->nameWithModule, 'presenterWithModule'));
		Assert::match('test/Module/presenters/Test/default.latte',$this->keeper->getView(':Test', 'presenterWithModule'));
		Assert::match('test/AhojModule/presenters//default.latte', $this->keeper->getView('Ahoj:', 'presenterWithModule'));
	}

	function testNullSuffix()
	{
		Assert::match('test/BackendModule/presenters/Homepage/default', $this->keeper->getView($this->nameWithModule, 'presenterWithModule', 'default', NULL));
	}

	function testNullSuffix2()
	{
		Assert::match('test/BackendModule/presenters/Homepage/default.', $this->keeper->getView($this->nameWithModule, 'presenterWithModule', 'default', ''));
	}
	function testNullAction()
	{
		Assert::match('test/BackendModule/presenters/Homepage/',$this->keeper->getView($this->nameWithModule, 'presenterWithModule', NULL, NULL));
	}
}

$test = new ViewKeeperTest($container);
$test->run();
