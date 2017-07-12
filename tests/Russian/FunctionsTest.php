<?php
namespace morphos\test\Russian;
require __DIR__.'/../../vendor/autoload.php';

use morphos\Gender;
use morphos\NumeralCreation;
use morphos\Russian\Cases;
use morphos\Russian\CardinalNumeral;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider verbsProvider()
	 */
	public function testVerb($verb, $gender, $correctVerb)
	{
		$this->assertEquals($correctVerb, \morphos\Russian\verb($verb, $gender));
	}

	public function verbsProvider()
	{
		return
		[
			['попал', Gender::MALE, 'попал'],
			['попал', Gender::FEMALE, 'попала'],
			['попался', Gender::MALE, 'попался'],
			['попался', Gender::FEMALE, 'попалась'],
		];
	}

	public function testDetectGender()
	{
		$this->assertEquals(Gender::MALE, \morphos\Russian\detectGender('Иванов Петр'));
		$this->assertEquals(Gender::FEMALE, \morphos\Russian\detectGender('Мирова Анастасия'));
	}

	public function testPluralize()
	{
		$this->assertEquals('сообщений', \morphos\Russian\pluralize('сообщение', 10));
	}
}
