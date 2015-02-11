<?php

namespace regexp\Tests;

use Nette;
use	Tester;
use	Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
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
		Assert::match($this->keeper->getView($this->name, 'controls'), 'test/controls/' . $this->name . '/default.latte');
		Assert::match($this->keeper->getView($this->name, 'presenters'), 'test/presenters/' . $this->name . '/default.latte');
		Assert::match($this->keeper->getView($this->name, 'layouts', 'layout'), 'test/' . '@layout.latte');
	}

	function testGetViewMagic()
	{
		Assert::match($this->keeper->getControlView($this->name), 'test/controls/' . $this->name . '/default.latte');
		Assert::match($this->keeper->getControlView($this->name, 'test'), 'test/controls/' . $this->name . '/test.latte');
		Assert::match($this->keeper->getControlView($this->name, 'test', 'foo'), 'test/controls/' . $this->name . '/test.foo');
		Assert::match($this->keeper->getControlView($this->name, 'test', '.foo'), 'test/controls/' . $this->name . '/test.foo');
	}

	function testCaseInsensitive()
	{
		Assert::match($this->keeper->getView($this->name, 'CaseInSensitives'), 'test/caseinsensitives/' . $this->name . '/default.latte');
		Assert::match($this->keeper->getCaseInSensitiveView($this->name), 'test/caseinsensitives/' . $this->name . '/default.latte');
	}

	function testModule()
	{
		Assert::match($this->keeper->getView($this->nameWithModule, 'presenterWithModule'), 'test/BackendModule/presenters/Homepage/default.latte');
		Assert::match($this->keeper->getView(':Test', 'presenterWithModule'), 'test/Module/presenters/Test/default.latte');
		Assert::match($this->keeper->getView('Ahoj:', 'presenterWithModule'), 'test/AhojModule/presenters//default.latte');
	}

	function testNullSuffix()
	{
		Assert::match($this->keeper->getView($this->nameWithModule, 'presenterWithModule', 'default', NULL), 'test/BackendModule/presenters/Homepage/default');
	}
}

$test = new ViewKeeperTest($container);
$test->run();
