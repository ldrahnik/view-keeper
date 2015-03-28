<?php

namespace ViewKeeper\Tests\Utils;

use ViewKeeper\Parser\Parser;
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
class ParserTest extends Tester\TestCase
{
	function testParser()
	{
		$patterns = [
			'foo' => 1,
			'bar' => 2
		];
		$mask = 'foo/bar';
		Assert::equal('1/2', Parser::replace($patterns, $mask));

		$patterns = [
			'foo' => null,
			'bar' => null
		];
		$mask = 'foo/bar';
		Assert::equal('/', Parser::replace($patterns, $mask));
	}
}

$test = new ParserTest();
$test->run();
