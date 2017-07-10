<?php
namespace morhos\test\Russian;
require __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Cases;
use morphos\Russian\LastNamesDeclension;
use morphos\NamesDeclension;

class LastNamesDeclensionTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider lastNamesProvider
     */
    public function testMutable($name, $gender) {
        $this->assertTrue(LastNamesDeclension::isMutable($name, $gender));
    }

    /**
     * @dataProvider lastNamesProvider
     */
    public function testGetCases($name, $gender, $name2, $name3, $name4, $name5, $name6) {
        $forms = LastNamesDeclension::getCases($name, $gender);
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
        $result = LastNamesDeclension::detectGender($name);
        if ($result !== null) $this->assertEquals($gender, $result);
    }

    public function lastNamesProvider() {
        return array(
            array('Смирнов', NamesDeclension::MALE, 'Смирнова', 'Смирнову', 'Смирнова', 'Смирновым', 'о Смирнове'),
            array('Кромской', NamesDeclension::MALE, 'Кромского', 'Кромскому', 'Кромского', 'Кромским', 'о Кромском'),
            array('Ус', NamesDeclension::MALE, 'Уса', 'Усу', 'Уса', 'Усом', 'об Усе'),
            array('Кузьмич', NamesDeclension::MALE, 'Кузьмича', 'Кузьмичу', 'Кузьмича', 'Кузьмичом', 'о Кузьмиче'),
            array('Берг', NamesDeclension::MALE, 'Берга', 'Бергу', 'Берга', 'Бергом', 'о Берге'),
            array('Медведь', NamesDeclension::MALE, 'Медведя', 'Медведю', 'Медведя', 'Медведем', 'о Медведе'),
            array('Суздаль', NamesDeclension::MALE, 'Суздаля', 'Суздалю', 'Суздаля', 'Суздалем', 'о Суздале'),
            array('Тронь', NamesDeclension::MALE, 'Троня', 'Троню', 'Троня', 'Тронем', 'о Троне'),

            array('Смирнова', NamesDeclension::FEMALE, 'Смирновой', 'Смирновой', 'Смирнову', 'Смирновой', 'о Смирновой'),
            array('Кромская', NamesDeclension::FEMALE, 'Кромской', 'Кромской', 'Кромскую', 'Кромской', 'о Кромской'),
            array('Закипная', NamesDeclension::FEMALE, 'Закипной', 'Закипной', 'Закипную', 'Закипной', 'о Закипной'),
            array('Зима', NamesDeclension::FEMALE, 'Зимы', 'Зиме', 'Зиму', 'Зимой', 'о Зиме'),
            array('Зоя', NamesDeclension::FEMALE, 'Зои', 'Зое', 'Зою', 'Зоей', 'о Зое'),
        );
    }

}
