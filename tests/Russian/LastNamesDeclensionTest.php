<?php
namespace morhos\test\Russian;
require __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Cases;
use morphos\Russian\LastNamesDeclension;
use morphos\NamesDeclension;

class LastNamesDeclensionTest extends \PHPUnit_Framework_TestCase {
    protected $declension;

    public function setUp() {
        $this->declension = new LastNamesDeclension();
    }

    /**
     * @dataProvider lastNamesProvider
     */
    public function testMutable($name, $gender) {
        $this->assertTrue($this->declension->isMutable($name, $gender));
    }

    /**
     * @dataProvider lastNamesProvider
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
     * @dataProvider lastNamesProvider()
     */
    public function testDetectGender($name, $gender) {
        $result = $this->declension->detectGender($name);
        if ($result !== null) $this->assertEquals($gender, $result);
    }

    public function lastNamesProvider() {
        return array(
            array('Смирнов', NamesDeclension::MAN, 'Смирнова', 'Смирнову', 'Смирнова', 'Смирновым', 'о Смирнове'),
            array('Кромской', NamesDeclension::MAN, 'Кромского', 'Кромскому', 'Кромского', 'Кромским', 'о Кромском'),
            array('Смирнова', NamesDeclension::WOMAN, 'Смирновой', 'Смирновой', 'Смирнову', 'Смирновой', 'о Смирновой'),
            array('Кромская', NamesDeclension::WOMAN, 'Кромской', 'Кромской', 'Кромскую', 'Кромской', 'о Кромской'),
            array('Зима', NamesDeclension::WOMAN, 'Зимы', 'Зиме', 'Зиму', 'Зимой', 'о Зиме'),
            array('Зоя', NamesDeclension::WOMAN, 'Зои', 'Зое', 'Зою', 'Зоей', 'о Зое'),
            array('Ус', NamesDeclension::MAN, 'Уса', 'Усу', 'Уса', 'Усом', 'об Усе'),
            array('Кузьмич', NamesDeclension::MAN, 'Кузьмича', 'Кузьмичу', 'Кузьмича', 'Кузьмичом', 'о Кузьмиче'),
            array('Берг', NamesDeclension::MAN, 'Берга', 'Бергу', 'Берга', 'Бергом', 'о Берге'),
            array('Медведь', NamesDeclension::MAN, 'Медведя', 'Медведю', 'Медведя', 'Медведем', 'о Медведе'),
            array('Суздаль', NamesDeclension::MAN, 'Суздаля', 'Суздалю', 'Суздаля', 'Суздалем', 'о Суздале'),
            array('Тронь', NamesDeclension::MAN, 'Троня', 'Троню', 'Троня', 'Тронем', 'о Троне'),
        );
    }

}
