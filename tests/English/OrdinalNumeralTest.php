<?php

namespace morphos\test\English;

use morphos\English\OrdinalNumeralGenerator;
use PHPUnit\Framework\TestCase;

class OrdinalNumeralTest extends TestCase
{
    /**
     * @dataProvider numbersProvider
     */
    public function testGeneration($number, $ordinal, $figOrdinal)
    {
        $this->assertEquals($ordinal, OrdinalNumeralGenerator::generate($number));
        $this->assertEquals($figOrdinal, OrdinalNumeralGenerator::generate($number, true));
    }

    public function numbersProvider()
    {
        return [
            [2, 'second', '2nd'],
            [30, 'thirtieth', '30th'],
            [132, 'one hundred thirty-second', '132nd'],
            [2595410, 'two million, five hundred ninety-five thousand, four hundred tenth', '2595410th'],
            [
                2021123132,
                'two billion, twenty-one million, one hundred twenty-three thousand, one hundred thirty-second',
                '2021123132nd',
            ],
        ];
    }
}
