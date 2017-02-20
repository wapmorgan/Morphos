<?php
namespace morhos\test\Russian;
require __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Cases;
use morphos\Russian\MiddleNamesDeclension;
use morphos\NamesDeclension;

class MiddleNamesDeclensionTest extends \PHPUnit_Framework_TestCase {
    protected $declension;

    public function setUp() {
        $this->declension = new MiddleNamesDeclension();
    }

    /**
     * @dataProvider middleNamesProvider
     */
    public function testGetCases($name, $gender, $name2, $name3, $name4, $name5, $name6) {
        $forms = $this->declension->getCases($name, $gender);
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
        $this->assertEquals($gender, $this->declension->detectGender($name));
    }

    public function middleNamesProvider() {
        return array(
            array('Владимирович', NamesDeclension::MAN, 'Владимировича', 'Владимировичу', 'Владимировича', 'Владимировичем', 'о Владимировиче'),
            array('Валерьянович', NamesDeclension::MAN, 'Валерьяновича', 'Валерьяновичу', 'Валерьяновича', 'Валерьяновичем', 'о Валерьяновиче'),
            array('Богдановна', NamesDeclension::WOMAN, 'Богдановны', 'Богдановне', 'Богдановну', 'Богдановной', 'о Богдановне'),
            array('Сергеевна', NamesDeclension::WOMAN, 'Сергеевны', 'Сергеевне', 'Сергеевну', 'Сергеевной', 'о Сергеевне'),
        );
    }

}
