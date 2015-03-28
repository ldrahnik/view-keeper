<?php

namespace ViewKeeper\Tests\Utils;

use ViewKeeper\Utils\Strings;
use Nette;
use	Tester;
use	Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * Class ViewKeeperTest
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\Tests
 *
 * @testCase
 */
class StringsTest extends Tester\TestCase
{
	function testStrafter()
	{
		$string = "Hello bar foo";
		$substring = "Hello";
		$out = Strings::strafter($string, $substring);
		Assert::Equal(' bar foo', $out);
	}

	function testStrbefore()
	{
		$string = "Hello bar foo";
		$substring = "bar";
		$out = Strings::strbefore($string, $substring);
		Assert::Equal('Hello ', $out);
	}
}

$test = new StringsTest();
$test->run();
