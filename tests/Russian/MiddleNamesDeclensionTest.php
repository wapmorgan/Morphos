<?php
namespace morhos\test\Russian;
require __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Cases;
use morphos\Russian\MiddleNamesDeclension;
use morphos\NamesDeclension;

class MiddleNamesDeclensionTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider middleNamesProvider
     */
    public function testGetCases($name, $gender, $name2, $name3, $name4, $name5, $name6) {
        $forms = MiddleNamesDeclension::getCases($name, $gender);
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
    public function testDetectGender($name, $gender) {
        $this->assertEquals($gender, MiddleNamesDeclension::detectGender($name));
    }

    public function middleNamesProvider() {
        return array(
            array('Владимирович', NamesDeclension::MALE, 'Владимировича', 'Владимировичу', 'Владимировича', 'Владимировичем', 'о Владимировиче'),
            array('Валерьянович', NamesDeclension::MALE, 'Валерьяновича', 'Валерьяновичу', 'Валерьяновича', 'Валерьяновичем', 'о Валерьяновиче'),
            array('Богдановна', NamesDeclension::FEMALE, 'Богдановны', 'Богдановне', 'Богдановну', 'Богдановной', 'о Богдановне'),
            array('Сергеевна', NamesDeclension::FEMALE, 'Сергеевны', 'Сергеевне', 'Сергеевну', 'Сергеевной', 'о Сергеевне'),
        );
    }

}
