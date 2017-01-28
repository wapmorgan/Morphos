<?php
require __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use morphos\BasicNamesDeclension as Declension;
use morphos\RussianLastNamesDeclension;
use morphos\RussianCases as Cases;

class RussianLastNamesDeclensionTest extends TestCase {
    protected $declension;

    public function setUp() {
        $this->declension = new RussianLastNamesDeclension();
    }

    /**
     * @dataProvider lastNamesProvider
     */
    public function testHasForms($name, $gender) {
        $this->assertTrue($this->declension->hasForms($name, $gender));
    }

    /**
     * @dataProvider lastNamesProvider
     */
    public function testGetForms($name, $gender, $name2, $name3, $name4, $name5, $name6) {
        $forms = $this->declension->getForms($name, $gender);
        $this->assertEquals(array(
            Cases::IMENIT => $name,
            Cases::RODIT => $name2,
            Cases::DAT => $name3,
            Cases::VINIT => $name4,
            Cases::TVORIT => $name5,
            Cases::PREDLOJ => $name6
            ), $forms);
    }

    public function lastNamesProvider() {
        return array(
            array('Смирнов', Declension::MAN, 'Смирнова', 'Смирнову', 'Смирнова', 'Смирновым', 'о Смирнове'),
            array('Кромской', Declension::MAN, 'Кромского', 'Кромскому', 'Кромского', 'Кромским', 'о Кромском'),
            array('Смирнова', Declension::WOMAN, 'Смирновой', 'Смирновой', 'Смирнову', 'Смирновой', 'о Смирновой'),
            array('Кромская', Declension::WOMAN, 'Кромской', 'Кромской', 'Кромскую', 'Кромской', 'о Кромской'),
            array('Зима', Declension::WOMAN, 'Зимы', 'Зиме', 'Зиму', 'Зимой', 'о Зиме'),
            array('Зоя', Declension::WOMAN, 'Зои', 'Зое', 'Зою', 'Зоей', 'о Зое'),
            array('Ус', Declension::MAN, 'Уса', 'Усу', 'Уса', 'Усом', 'об Усе'),
            array('Кузьмич', Declension::MAN, 'Кузьмича', 'Кузьмичу', 'Кузьмича', 'Кузьмичом', 'о Кузьмиче'),
            array('Берг', Declension::MAN, 'Берга', 'Бергу', 'Берга', 'Бергом', 'о Берге'),
            array('Медведь', Declension::MAN, 'Медведя', 'Медведю', 'Медведя', 'Медведем', 'о Медведе'),
            array('Суздаль', Declension::MAN, 'Суздаля', 'Суздалю', 'Суздаля', 'Суздалем', 'о Суздале'),
            array('Тронь', Declension::MAN, 'Троня', 'Троню', 'Троня', 'Тронем', 'о Троне'),
        );
    }

}
