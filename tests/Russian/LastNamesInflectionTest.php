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
        return [
            ['Смирнов', NamesInflection::MALE, 'Смирнова', 'Смирнову', 'Смирнова', 'Смирновым', 'о Смирнове'],
            ['Кромской', NamesInflection::MALE, 'Кромского', 'Кромскому', 'Кромского', 'Кромским', 'о Кромском'],
            ['Ус', NamesInflection::MALE, 'Уса', 'Усу', 'Уса', 'Усом', 'об Усе'],
            ['Кузьмич', NamesInflection::MALE, 'Кузьмича', 'Кузьмичу', 'Кузьмича', 'Кузьмичом', 'о Кузьмиче'],
            ['Берг', NamesInflection::MALE, 'Берга', 'Бергу', 'Берга', 'Бергом', 'о Берге'],
            ['Медведь', NamesInflection::MALE, 'Медведя', 'Медведю', 'Медведя', 'Медведем', 'о Медведе'],
            ['Суздаль', NamesInflection::MALE, 'Суздаля', 'Суздалю', 'Суздаля', 'Суздалем', 'о Суздале'],
            ['Тронь', NamesInflection::MALE, 'Троня', 'Троню', 'Троня', 'Тронем', 'о Троне'],
            ['Толстой', NamesInflection::MALE, 'Толстого', 'Толстому', 'Толстого', 'Толстым', 'о Толстом'],
            ['Стальной', NamesInflection::MALE, 'Стального', 'Стальному', 'Стального', 'Стальным', 'о Стальном'],
            ['Жареный', NamesInflection::MALE, 'Жареного', 'Жареному', 'Жареного', 'Жареным', 'о Жареном'],

            ['Смирнова', NamesInflection::FEMALE, 'Смирновой', 'Смирновой', 'Смирнову', 'Смирновой', 'о Смирновой'],
            ['Кромская', NamesInflection::FEMALE, 'Кромской', 'Кромской', 'Кромскую', 'Кромской', 'о Кромской'],
            ['Закипная', NamesInflection::FEMALE, 'Закипной', 'Закипной', 'Закипную', 'Закипной', 'о Закипной'],
            ['Зима', NamesInflection::FEMALE, 'Зимы', 'Зиме', 'Зиму', 'Зимой', 'о Зиме'],
            ['Зоя', NamesInflection::FEMALE, 'Зои', 'Зое', 'Зою', 'Зоей', 'о Зое'],
            ['Молодыха', NamesInflection::FEMALE, 'Молодыхи', 'Молодыхе', 'Молодыху', 'Молодыхой', 'о Молодыхе'],
            ['Стальная', NamesInflection::FEMALE, 'Стальной', 'Стальной', 'Стальную', 'Стальной', 'о Стальной'],

            // foreign names
            ['Мартен-Люган', NamesInflection::MALE, 'Мартена-Люгана', 'Мартену-Люгану', 'Мартена-Люгана', 'Мартеном-Люганом', 'о Мартене-Люгане'],
            ['Копусов-Долинин', NamesInflection::MALE, 'Копусова-Долинина', 'Копусову-Долинину', 'Копусова-Долинина', 'Копусовым-Долининым', 'о Копусове-Долинине'],
//            ['Кучера-Бози', NamesInflection::MALE, 'Кучера-Бози', 'Кучере-Бози', 'Кучера-Бози', 'Кучером-Бози', 'о Кучере-Бози'],
        ];
    }

    /**
     * @dataProvider immutableNamesProvider()
     */
    public function testImmutable($name, $gender)
    {
        $this->assertFalse(LastNamesInflection::isMutable($name, $gender));
    }

    public function immutableNamesProvider()
    {
        return [
            ['Фоминых', NamesInflection::MALE],
            ['Хитрово', NamesInflection::MALE],
        ];
    }
}
