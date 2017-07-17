<?php
namespace morhos\test\English;

require_once __DIR__.'/../../vendor/autoload.php';

use morphos\English\CardinalNumeralGenerator;

class CardinalNumeralTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider numbersProvider
     */
    public function testGeneration($number, $cardinal)
    {
        $this->assertEquals($cardinal, CardinalNumeralGenerator::generate($number));
    }

    public function numbersProvider()
    {
        return array(
            array(132, 'one hundred thirty-two'),
            array(2595410, 'two million, five hundred ninety-five thousand, four hundred ten'),
            array(2021123132, 'two billion, twenty-one million, one hundred twenty-three thousand, one hundred thirty-two'),
        );
    }
}
