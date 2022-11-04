<?php

namespace morphos\test\English;

use morphos\English\CardinalNumeralGenerator;
use PHPUnit\Framework\TestCase;

class CardinalNumeralTest extends TestCase
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
        return [
            [132, 'one hundred thirty-two'],
            [2595410, 'two million, five hundred ninety-five thousand, four hundred ten'],
            [2021123132, 'two billion, twenty-one million, one hundred twenty-three thousand, one hundred thirty-two'],
        ];
    }
}
