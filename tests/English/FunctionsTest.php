<?php
namespace morphos\test\English;

use morphos\Gender;
use morphos\NumeralGenerator;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
	public function testPluralize()
    {
        $this->assertEquals('10 messages', \morphos\English\pluralize(10, 'message'));
    }
}
