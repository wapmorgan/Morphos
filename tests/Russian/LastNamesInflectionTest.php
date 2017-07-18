<?php
namespace morhos\test\Russian;

require __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Cases;
use morphos\Russian\LastNamesInflection;
use morphos\NamesInflection;

class LastNamesInflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider lastNamesProvider
     */
    public function testMutable($name, $gender)
    {
        $this->assertTrue(LastNamesInflection::isMutable($name, $gender));
    }

    /**
     * @dataProvider lastNamesProvider
     */
    public function testGetCases($name, $gender, $name2, $name3, $name4, $name5, $name6)
    {
        $forms = LastNamesInflection::getCases($name, $gender);
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
    public function testDetectGender($name, $gender)
    {
        $result = LastNamesInflection::detectGender($name);
        if ($result !== null) {
            $this->assertEquals($gender, $result);
        }
    }

    public function lastNamesProvider()
    {
        return array(
            array('Смирнов', NamesInflection::MALE, 'Смирнова', 'Смирнову', 'Смирнова', 'Смирновым', 'о Смирнове'),
            array('Кромской', NamesInflection::MALE, 'Кромского', 'Кромскому', 'Кромского', 'Кромским', 'о Кромском'),
            array('Ус', NamesInflection::MALE, 'Уса', 'Усу', 'Уса', 'Усом', 'об Усе'),
            array('Кузьмич', NamesInflection::MALE, 'Кузьмича', 'Кузьмичу', 'Кузьмича', 'Кузьмичом', 'о Кузьмиче'),
            array('Берг', NamesInflection::MALE, 'Берга', 'Бергу', 'Берга', 'Бергом', 'о Берге'),
            array('Медведь', NamesInflection::MALE, 'Медведя', 'Медведю', 'Медведя', 'Медведем', 'о Медведе'),
            array('Суздаль', NamesInflection::MALE, 'Суздаля', 'Суздалю', 'Суздаля', 'Суздалем', 'о Суздале'),
            array('Тронь', NamesInflection::MALE, 'Троня', 'Троню', 'Троня', 'Тронем', 'о Троне'),

            array('Смирнова', NamesInflection::FEMALE, 'Смирновой', 'Смирновой', 'Смирнову', 'Смирновой', 'о Смирновой'),
            array('Кромская', NamesInflection::FEMALE, 'Кромской', 'Кромской', 'Кромскую', 'Кромской', 'о Кромской'),
            array('Закипная', NamesInflection::FEMALE, 'Закипной', 'Закипной', 'Закипную', 'Закипной', 'о Закипной'),
            array('Зима', NamesInflection::FEMALE, 'Зимы', 'Зиме', 'Зиму', 'Зимой', 'о Зиме'),
            array('Зоя', NamesInflection::FEMALE, 'Зои', 'Зое', 'Зою', 'Зоей', 'о Зое'),
			array('Молодыха', NamesInflection::FEMALE, 'Молодыхи', 'Молодыхе', 'Молодыху', 'Молодыхой', 'о Молодыхе'),
        );
    }
}