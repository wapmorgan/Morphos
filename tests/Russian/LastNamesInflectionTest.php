<?php
namespace morphos\test\Russian;

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
            ['Смирнов', NamesInflection::MALE, 'Смирнова', 'Смирнову', 'Смирнова', 'Смирновым', 'Смирнове'],
            ['Кромской', NamesInflection::MALE, 'Кромского', 'Кромскому', 'Кромского', 'Кромским', 'Кромском'],
            ['Ус', NamesInflection::MALE, 'Уса', 'Усу', 'Уса', 'Усом', 'Усе'],
            ['Кузьмич', NamesInflection::MALE, 'Кузьмича', 'Кузьмичу', 'Кузьмича', 'Кузьмичом', 'Кузьмиче'],
            ['Берг', NamesInflection::MALE, 'Берга', 'Бергу', 'Берга', 'Бергом', 'Берге'],
            ['Медведь', NamesInflection::MALE, 'Медведя', 'Медведю', 'Медведя', 'Медведем', 'Медведе'],
            ['Суздаль', NamesInflection::MALE, 'Суздаля', 'Суздалю', 'Суздаля', 'Суздалем', 'Суздале'],
            ['Тронь', NamesInflection::MALE, 'Троня', 'Троню', 'Троня', 'Тронем', 'Троне'],
            ['Толстой', NamesInflection::MALE, 'Толстого', 'Толстому', 'Толстого', 'Толстым', 'Толстом'],
            ['Стальной', NamesInflection::MALE, 'Стального', 'Стальному', 'Стального', 'Стальным', 'Стальном'],
            ['Жареный', NamesInflection::MALE, 'Жареного', 'Жареному', 'Жареного', 'Жареным', 'Жареном'],
            ['Прожога', NamesInflection::MALE, 'Прожоги', 'Прожоге', 'Прожогу', 'Прожогой', 'Прожоге'],

            ['Смирнова', NamesInflection::FEMALE, 'Смирновой', 'Смирновой', 'Смирнову', 'Смирновой', 'Смирновой'],
            ['Кромская', NamesInflection::FEMALE, 'Кромской', 'Кромской', 'Кромскую', 'Кромской', 'Кромской'],
            ['Закипная', NamesInflection::FEMALE, 'Закипной', 'Закипной', 'Закипную', 'Закипной', 'Закипной'],
            ['Зима', NamesInflection::FEMALE, 'Зимы', 'Зиме', 'Зиму', 'Зимой', 'Зиме'],
            ['Зоя', NamesInflection::FEMALE, 'Зои', 'Зое', 'Зою', 'Зоей', 'Зое'],
            ['Молодыха', NamesInflection::FEMALE, 'Молодыхи', 'Молодыхе', 'Молодыху', 'Молодыхой', 'Молодыхе'],
            ['Стальная', NamesInflection::FEMALE, 'Стальной', 'Стальной', 'Стальную', 'Стальной', 'Стальной'],
            ['Завгородняя', NamesInflection::FEMALE, 'Завгородней', 'Завгородней', 'Завгороднюю', 'Завгородней', 'Завгородней'],

            // foreign names
            ['Мартен-Люган', NamesInflection::MALE, 'Мартена-Люгана', 'Мартену-Люгану', 'Мартена-Люгана', 'Мартеном-Люганом', 'Мартене-Люгане'],
            ['Копусов-Долинин', NamesInflection::MALE, 'Копусова-Долинина', 'Копусову-Долинину', 'Копусова-Долинина', 'Копусовым-Долининым', 'Копусове-Долинине'],
            ['Кучера-Бози', NamesInflection::MALE, 'Кучеры-Бози', 'Кучере-Бози', 'Кучеру-Бози', 'Кучерой-Бози', 'Кучере-Бози'],
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
            ['Бози', NamesInflection::MALE],
        ];
    }
}
