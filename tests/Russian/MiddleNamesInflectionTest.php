<?php
namespace morhos\test\Russian;

require __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Cases;
use morphos\Russian\MiddleNamesInflection;
use morphos\NamesInflection;

class MiddleNamesInflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider middleNamesProvider
     */
    public function testGetCases($name, $gender, $name2, $name3, $name4, $name5, $name6)
    {
        $forms = MiddleNamesInflection::getCases($name, $gender);
        $this->assertEquals(array(
            Cases::IMENIT => $name,
            Cases::RODIT => $name2,
            Cases::DAT => $name3,
            Cases::VINIT => $name4,
            Cases::TVORIT => $name5,
            Cases::PREDLOJ => $name6
            ), $forms);
    }

    /**
     * @dataProvider middleNamesProvider()
     */
    public function testDetectGender($name, $gender)
    {
        $this->assertEquals($gender, MiddleNamesInflection::detectGender($name));
    }

    public function middleNamesProvider()
    {
        return array(
            array('Владимирович', NamesInflection::MALE, 'Владимировича', 'Владимировичу', 'Владимировича', 'Владимировичем', 'Владимировиче'),
            array('Валерьянович', NamesInflection::MALE, 'Валерьяновича', 'Валерьяновичу', 'Валерьяновича', 'Валерьяновичем', 'Валерьяновиче'),
            array('Богдановна', NamesInflection::FEMALE, 'Богдановны', 'Богдановне', 'Богдановну', 'Богдановной', 'Богдановне'),
            array('Сергеевна', NamesInflection::FEMALE, 'Сергеевны', 'Сергеевне', 'Сергеевну', 'Сергеевной', 'Сергеевне'),
        );
    }

    /**
     * @dataProvider mutableNamesProvider()
     */
    public function testMutableNames($name, $gender)
    {
        $this->assertTrue(MiddleNamesInflection::isMutable($name, $gender));
    }

    public function mutableNamesProvider()
    {
        return array(
            array('Иванович', NamesInflection::MALE),
            array('Петровна', NamesInflection::FEMALE),
        );
    }

    /**
     * @dataProvider middleNamesProvider()
     */
    public function testGetCase($name, $gender, $case2)
    {
        $this->assertEquals($case2, MiddleNamesInflection::getCase($name, Cases::RODIT, $gender));
    }
}
