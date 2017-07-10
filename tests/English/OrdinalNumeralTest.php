<?php
namespace morhos\test\English;
require_once __DIR__.'/../../vendor/autoload.php';

use morphos\English\OrdinalNumeral;

class OrdinalNumeralTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider numbersProvider
     */
    public function testGeneration($number, $ordinal, $figOrdinal) {
        $this->assertEquals($ordinal, OrdinalNumeral::generate($number));
        $this->assertEquals($figOrdinal, OrdinalNumeral::generate($number, true));
    }

    public function numbersProvider() {
        return array(
            array(132, 'one hundred thirty-second', '132nd'),
            array(2595410, 'two million, five hundred ninety-five thousand, four hundred tenth', '2595410th'),
            array(2021123132, 'two billion, twenty-one million, one hundred twenty-three thousand, one hundred thirty-second', '2021123132nd'),
        );
    }
}
